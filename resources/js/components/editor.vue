<template>
    <div class="w-10 main-editor-page" v-if="config.isReady">
        <div id="main-nav" class="nav nav-dark">
            <div class="nav-logo">
                <img src="https://asst.ml/favicon.svg" width="40" alt="">
            </div>
            <div class="nav-body ml-3">
                <div class="nav-item v-center">
                    <span class="">Live  </span>&nbsp;&nbsp;
                    <label class="button-toggle bg-white title-tip title-tip-bottom title-tip-light"  data-title="Run Code Live">
                        <input type="checkbox" v-model="config.isLive">
                        <div class="button-toggle-inner"></div>
                    </label>
                </div>
                <div class="nav-item ml-2" v-if="loged">
                    <div class="badge badge-prime badge-s ripple" @click="like()">
                        <i :class="['ion ion-heart pointer', liked ? 'text-sec' : '']" style="font-size: 1.8rem" ></i>
                        <span class="ml-1">
                            {{likedBy}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mainPanel">
            <div class="mainPanel-left">
                <div class="left-window">
                    <div class="left-window-left">
                        <div data-title="Files" :class="['left-window-item title-tip title-tip-right title-tip-light' , {'left-window-item-active' : (config.window === 'window-fs')}]" @click="chnageWindow('window-fs')"> 
                            <i class="ion ion-folder"></i>
                        </div>
                        <div data-title="Settings" :class="['left-window-item title-tip title-tip-right title-tip-light' , {'left-window-item-active' : (config.window === 'window-settings')}]" @click="chnageWindow('window-settings')">
                            <i class="ion ion-ios-gear-outline"></i>
                        </div>
                        <div data-title="Run Code" class="left-window-item title-tip title-tip-right title-tip-light" @click="runCode()">
                            <i class="ion ion-play"></i>
                        </div>
                        <div data-title="Save Code" class="left-window-item title-tip title-tip-right title-tip-light" @click="upload()"  v-if="data.own">
                            <i class="ion ion-paper-airplane"></i>
                        </div>
                        <div data-title="Fork This Repo" class="left-window-item title-tip title-tip-right title-tip-light" @click="fork()" v-if="!data.own && loged">
                            <i class="ion ion-fork-repo"></i>
                        </div>
                        <div data-title="Project Details" :class="['left-window-item title-tip title-tip-right title-tip-light' , {'left-window-item-active' : (config.window === 'window-user')}]" @click="chnageWindow('window-user')">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainPanel-right">
                
        <div :class="['panel', {'panel-open' : config.codePanelOpen}]" data-usePanel="left" id="codePanel">

            <div class="panel-left panel-left-fs d-f space-b dir-col">
                <div class="fs-nav" v-show="config.window === 'window-fs'">
                    <div class="fs-file"
                        v-for="file in fs"
                        :key="file.name"
                        :class="{'fs-file-active' : file.active}"
                        @click="changeFile(file)">
                        <div class="fs-file-name">
                            <img :src="'/icons/file_type_' + file.lang + '@2x.png'" alt="">
                            {{file.name}}</div>
                    </div>
                </div>
                <option-tab 
                    v-show="config.window === 'window-settings'"
                    :ops="editor">
                </option-tab>
                <user-tab 
                    v-show="config.window === 'window-user'"
                    :user="user"
                    :tags="tags">

                </user-tab>
            </div>
            <div :class="['panel-right panel-right-fs', 'view-' + activeView]">
                <div id="codeArea" class="bg-white" v-if="config.isReady">
                    <monaco-editor
                            :ops="file" class=""
                            v-for="file in fs"
                            :key="file.name"
                            v-show="file.active">
                    </monaco-editor>
                </div>
                <div id="resultArea">
                    <app-browser></app-browser>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</template>

<script>
    import monaco from "./monaco";
    import browser from "./browser";
    import optionTab from "./optionTab";
    import userTab from "./userTab";
    import axios from "axios";

    export default {
        props: {
            demo: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                tags: [],
                fs: [],
                data: null,
                result: '',
                config: {
                    isLive: false,
                    isReady: false,
                    showOptions: false,
                    window: 'no-window',
                    codePanelOpen: true
                },
                loged: false,
                liked: false,
                likedBy: 12,
                activeView: "left-right",
                editor: {}
            }
        },
        computed: {
            username() {
                let abc = window.location.pathname;
                abc = abc.replace("/editor/", "");
                abc = abc.replace(abc.substring(abc.indexOf("/")), "");
                return abc;
            }
        },
        mounted() {
            this.activeView = this.$store.state.all.activeView;
            this.getContent();
            this.$eBus.$on("changeView", function(view) {
                this.activeView = view.name;
            }.bind(this));
            document.head.innerHTML = document.head.innerHTML + `
        <link href="https://fonts.googleapis.com/css?family=Fira+Mono" rel="stylesheet">`;
        },
        methods: {
            like() {
                let url = this.demo ? "/editor/demo-project/like" : window.location.pathname + "/like";
                axios.get(url).then(res => {
                    if(this.liked) {
                        this.liked = false;
                        this.likedBy--;
                    } else {
                        this.liked = true;
                        this.likedBy++;
                    }
                }).catch(err => {
                    console.log(err);
                })
            },
            fork() {
                let url = this.demo ? "/editor/demo-project/fork" : window.location.pathname + "/fork";
                axios.post(url).then(res => {
                    addMsg("prime", "You Just Forked This Repo");
                }).catch(err => {
                    addMsg("danger", "Can not Fork This Repo")
                });
            },
            chnageWindow(name) {
                if(name === this.config.window) {
                    this.config.codePanelOpen = true;
                    this.config.window = 'no-window'
                } else {
                    this.config.codePanelOpen = false;
                    this.config.window = name;
                }
            },
            changeFile(file) {
                this.fs.map(function (it) {
                    it.active = false;
                });
                file.active = true;
            },
            listen() {
                this.$eBus.$on("fileChanges", function (file) {
                    this.fs[file.index].content = file.content;
                    if(this.config.isLive) {
                        this.runCode();
                    }
                }.bind(this));
            },
            renderFs() {
                this.fs.map((file, index) => {
                    file.index = index;
                    file.uId = file.name + "-" + index;
                });
                this.config.isReady = true;
            },
            runCode() {
                this.$eBus.$emit("runCode", this.fs);
            },
            upload() {
                this.$eBus.$emit("uploadCode", this.fs);
            },
            getContent() {
                let it = this;
                let url = this.demo ? "/editor/demo-project/get" : window.location.pathname + "/get";
                axios.get(url).then(({data}) => {
                    this.data = data;
                    this.liked = data.liked;
                    this.likedBy = data.likedBy;
                    this.loged = data.loged;
                    this.user = data.user;
                    this.tags = data.tags;
                    this.$store.state.allowSave = (data.own && !this.demo) ;
                    let meta = data.file.meta;
                    this.$store.state.initial = meta;
                    meta = JSON.parse(meta);
                    this.$store.state.all = meta;
                    this.fs = meta.fs;
                    this.result = meta.result;
                    this.editor = meta.editor;
                    this.activeView = meta.activeView;
                    this.renderFs();
                    this.listen();
                    this.runCode();
                });
            }
        },
        components: {
            monacoEditor: monaco,
            appBrowser: browser,
            optionTab,
            userTab
        }
    }
</script>
