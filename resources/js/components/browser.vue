<template>
    <div id="editor-editor" class="pos-window">
        <div id="editor-top" class="group space-b">
            <div data-title="Refresh" class="refresh-icon v-center title-tip title-tip-bottom title-tip-light" @click="renderPage()">
                <i class="ion ion-ios-loop text-white mx-a pointer"></i>
            </div>
            <input class="url-bar v-center space-a w-7" disabled :value="this.title.substring(0, 25)">
            <div data-title="open in new window" class="refrsh-icon v-center title-tip title-tip-left title-tip-light" @click="launchBrowser()">
                <i class="ion ion-ios-browsers-outline text-white pointer" style="font-size: 1.8rem;"></i>
            </div>
        </div>
        <div id="editor-bottom">
            <iframe :src="src" allow="midi; geolocation; microphone; camera; encrypted-media;" sandbox="allow-forms allow-scripts allow-same-origin allow-modals allow-popups" allowfullscreen="" allowpaymentrequest="" id="app-browser-window" frameborder="0" class="pos-window"></iframe>
        </div>
    </div>
</template>

<script>

    import axios from "axios";

    export default {
        data() {
            return { 
                fs: null,
                title: "Document",
                mainBrowser: null,
                src: ''
            }
        },
        mounted() {
            this.loadLibs();
            this.browser = document.getElementById("app-browser-window");
            this.bDoc = this.browser.contentWindow.document;
            this.$eBus.$on("runCode", this.renderPage)
            this.$eBus.$on("autoSave", this.autoSave);
            this.$eBus.$on("uploadCode", this.uploadCode);
            this.$eBus.$on("lib-added", this.loadLibs);
            this.$eBus.$on("lib-deleted", this.loadLibs);
            this.renderPage(this.$store.state.all.fs);
            spyder.rerun();
        },
        methods: {
            launchBrowser() {
                this.$eBus.$emit("changeView", {
                    name: "left",
                    active: true
                });
                this.mainBrowser = window.open(this.createBlob(), "test");
                this.reRender();
            },
            renderPage(fs = this.fs) {
                window.location.protocol === "https:" ? window.console.clear() : console.log();
                this.fs =fs;
                let __hm = this.fs[0].content;
                let __cs = this.fs[1].content;
                let __js = this.fs[2].content;
                __hm = __hm.replace("<loadcss/>", `${this.getLib('b-css') + '<style>' + __cs +'</style>' + this.getLib('a-css')}`);
                __hm = __hm.replace("<loadjs/>", `${this.getLib('b-js') + '<script>' + __js +'</' + 'script>' + this.getLib('a-js')}`);

                let blob = this.createBlob(__hm);
                this.src = blob;
                this.$store.state.all.fs = this.fs;
                this.$store.state.all.result = __hm;

                if(document.getElementById("app-browser-window").contentWindow.document.querySelector("title")) {
                    this.title = document.getElementById("app-browser-window").contentWindow.document.querySelector("title").innerText;
                }

                if(this.mainBrowser) {
                    this.mainBrowser.location.href = blob;
                }
            },
            autoSave(fs) {
                if(this.$store.state.autoSave) {
                    this.uploadCode(fs, false);
                }
            },
            createBlob(__hm = this.result) {
                let blob = new Blob([__hm], {
                    type: "text/html"
                });

                return window.URL.createObjectURL(blob);
            },
            reRender() {
                this.renderPage(this.fs);
            },
            uploadCode(fs, runAlso = true) {

                if(!this.$store.state.allowSave) {
                    addMsg("warn", "unauthorized");
                    return false;
                }

                
                if(runAlso) {
                    this.renderPage(fs);
                }

                let codeCollection = JSON.stringify({
                    activeView: this.$store.state.all.activeView,
                    fs: this.fs,
                    lib: this.$store.state.all.lib,
                    result: this.prodResult(),
                    editor: this.$store.state.all.editor});
                let isInitial = (codeCollection === this.$store.state.initial)
                if(!isInitial) {
                    this.$store.state.initial = codeCollection;
                    axios.post(window.location.href, {
                        meta: codeCollection
                    }).then(res => {
                        if(runAlso) {
                            addMsg("prime", "Saved");
                        }
                    }).catch(err => {
                        if(runAlso) {
                            addMsg("warn", "Error During Save");
                        }
                    })
                } else {
                    addMsg("warn", "Nothing Changed");
                }
            },
            loadLibs() {
                let fin = [];
                this.$store.state.all.lib.forEach((item, index) => {
                    axios.get(item.url).then(res => {
                        fin.push({
                            url : item.url,
                            data: res.data,
                            type: item.type,
                            location: item.location,
                            name: item.name
                        });
                        (function() {
                            if(this.$store.state.all.lib.length === (index + 1)) {
                                this.$store.state.libs = fin;
                                this.renderPage();
                            }
                        }.bind(this))();
                    }).catch(err => {
                        console.error("Cannot load: ", err);
                    })
                });
            },
            getLib(op) {
                let __css = ``;
                let __js = ``;

                this.$store.state.libs.map(function(item) {
                    if(op === item.location) {
                        if(item.type === 'css') {
                            __css = __css + '   ' + `${'<style>' + item.data +'</style>'}`;
                        }

                        if(item.type === 'js') {
                            __js = __js + '   ' + `${'<script>' + item.data +'</' + 'script>'}`;
                        }
                    }
                });

                return __css + '  ' + __js;
            },
            getProdLib(op) {
                let __css = ``;
                let __js = ``;

                this.$store.state.all.lib.map(function(item) {
                    if(op === item.location) {
                        if(item.type === 'css') {
                            __css = __css + '   ' + `<link rel="stylesheet" type="text/css" href="${item.url}">`;
                        }

                        if(item.type === 'js') {
                            __js = __js + '   ' + `<script type="text/javascript" src="${item.url}">` + '</' + 'script>';
                        }
                    }
                });

                return __css + '  ' + __js;
            },
            prodResult() {
                let __hm = this.fs[0].content;
                let __cs = this.fs[1].content;
                let __js = this.fs[2].content;
                __hm = __hm.replace("<loadcss/>", `${this.getProdLib('b-css') + '<style>' + __cs +'</style>' + this.getProdLib('a-css')}`);
                __hm = __hm.replace("<loadjs/>", `${this.getProdLib('b-js') + '<script>' + __js +'</' + 'script>' + this.getProdLib('a-js')}`);
                return __hm;
            }

        }
    }
</script>