<template>
    <div class="w-10 main-editor-page" v-if="config.isReady">
        <!--<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <div id="main-nav" class="nav nav-dark nav-corner nav-hide-sm">
            <div class="nav-logo ml-1">
                <!-- <div class="c-hm mr-1" data-panel="codePanel">
                    <div class="c-hm-bar"></div>
                </div> -->
                <img src="https://asst.ml/favicon.svg" width="40" alt="">
            </div>
            <div class="nav-opener">
                <div class="hamburger"></div>
            </div>
            <div class="nav-body">
                <div class="nav-item v-center">
                    <span class="">Live  </span>&nbsp;&nbsp;
                    <label class="button-toggle">
                        <input type="checkbox" v-model="config.isLive">
                        <div class="button-toggle-inner"></div>
                    </label>
                </div>
                <div class="nav-item v-center">
                    <div class="btn btn-dark btn-s ripple" @click="runCode()">Run</div>
                </div>
                <div class="nav-item v-center" v-if="user.currentUser.username === username">
                    <div class="btn btn-dark btn-s ripple" @click="upload()">Save</div>
                </div>
                <!-- <div class="btn btn-dark btn-s ion ion-settings" @click="config.showOptions = !config.showOptions"></div> -->
            </div>
        </div>
        <div :class="['panel', {'panel-open' : config.codePanelOpen}]" data-usePanel="left" id="codePanel">
            <div class="panel-left panel-left-fs d-f space-b dir-col">
                <div class="left-window">
                    <div class="left-window-left">
                        <div :class="['left-window-item' , {'left-window-item-active' : (config.window === 'window-fs')}]" @click="chnageWindow('window-fs')"> 
                            <i class="ion ion-folder"></i>
                        </div>
                        <div :class="['left-window-item' , {'left-window-item-active' : (config.window === 'window-settings')}]" @click="chnageWindow('window-settings')">
                            <i class="ion ion-ios-gear-outline"></i>
                        </div>
                    </div>
                    <div class="left-window-right">
                        <div class="fs-nav" v-if="config.window === 'window-fs'">
                            <div class="fs-file"
                                v-for="file in fs"
                                :key="file.name"
                                :class="{'fs-file-active' : file.active}"
                                @click="changeFile(file)">
                                <div class="fs-file-name">{{file.name}}</div>
                            </div>

                        </div>
                        <option-tab 
                            v-if="config.window === 'window-settings'"
                            :ops="editor">
                        </option-tab>
                    </div>
                </div>
                <!-- 
                <div class="w-10 text-center text-white class mute">
                    A invention By Gaurav Bhardwaj
                </div> -->
            </div>
            <div :class="['panel-right panel-right-fs', 'view-' + activeView]">
                <div id="codeArea" class="bg-white" v-if="config.isReady">
                    <monaco-editor
                            :ops="file" class=""
                            v-for="file in fs"
                            :key="file.name"
                            :class="{'d-none' : !file.active}">
                    </monaco-editor>
                </div>
                <div id="resultArea">
                    <app-browser></app-browser>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import monaco from "./monaco";
    import browser from "./browser";
    import optionTab from "./optionTab";
    import axios from "axios";

    export default {
        data() {
            return {
                fs: [],
                result: '',
                config: {
                    isLive: false,
                    isReady: false,
                    showOptions: false,
                    window: 'window-fs',
                    codePanelOpen: false
                },
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
            }.bind(this))
        },
        methods: {
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
                axios.get(window.location.pathname + "/get").then(({data}) => {
                    it.user = data[0];
                    this.user = it.user;
                    this.user.currentUser = JSON.parse(this.user.currentUser);
                    this.$store.state.allowSave = this.username === this.user.currentUser.username;
                    let meta = this.user.projects[0].files[0].meta;
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
            optionTab
        }
    }
</script>
