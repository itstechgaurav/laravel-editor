<template>
    <div id="editor-options">
        <div class="w-10 mt-3 p-1">
            <div class="box mb-2">
                <div class="label d-b mute text-white">Select View</div>
                <div class="logo-views c">
                    <div :class="['logo-view', 'logo-view-' + view.name, view.active ? 'logo-view-active'  : '']" @click="changeView(view)" v-for="(view, index) in views" :key="index"></div>
                </div>
            </div>
            <div class="box mb-2">
                <div class="label d-b mute text-white">Select Theme</div>
                <div class="dropdown dropdown-white-dark">
                    <div class="dropdown-head">
                        {{this.selectedTheme.name}}
                    </div>
                    <div class="dropdown-body">
                        <div class="dropdown-item" @click="changeTheme(theme)" v-for="(theme, index) in themes" :key="index">{{theme.name}}</div>
                    </div>
                </div>
            </div>
            <div class="box mb-2">
                <div class="label d-b mb-1 mute text-white">Font Size</div>
                <div class="group over rad-s">
                    <div class="ripple v-center btn btn-prime btn-s btn-simple ion ion-minus-round" @click="ops.fontSize > 5 ? ops.fontSize-- : 1"></div>
                    <input type="text" min="5" v-model="ops.fontSize" class="text-center input anm-line-resets theme-white-dark" disabled style="width: 50px;">
                    <div class="ripple v-center btn btn-prime btn-s btn-simple ion-plus-round" @click="ops.fontSize++"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

    export default {
        props: ['ops', 'activeView'],
        data() {
            return {
                views: [
                    {
                        name: "left",
                        active: false
                    }, {
                        name: "right",
                        active: false
                    }, {
                        name: "left-right",
                        active: false,
                    }, {
                        name: "right-left",
                        active: false
                    }, {
                        name: "top-bottom",
                        active: false
                    }, {
                        name: "bottom-top"
                    }
                ],
                isReady: false,
                selectedTheme: {
                    name: "vs-light",
                    value: "vs-light"
                },
                themes: [{
                    name: "vs-light",
                    value: "vs-light"
                }, {
                    name: "vs-dark",
                    value: "vs-dark"
                }]
            }
        },
        created() {
            this.getThemes();
            this.selectedTheme = this.$store.state.all.editor.theme;
            this.changeOptions();
        },
        mounted() {
            this.views.map(function(it) {
                if(it.name == this.$store.state.all.activeView) {
                    it.active = true
                }
            }.bind(this));
            this.$eBus.$on("changeView", function(view) {
                this.views.map(function(item) {
                    if(item.name === view.name) {
                        item.active = true;
                        this.$store.state.all.activeView = view.name;
                    } else {
                        item.active = false;
                    }
                }.bind(this));
            }.bind(this));
        },
        watch: {
            ops: {
                handler: "changeOptions",
                deep: true,
                immediate: true
            }
        },
        methods: {
            getThemes() {
                axios.get("/themes/theme-lists.json").then(res => {
                    Object.keys(res.data).forEach(function(it) {
                        this.themes.push({
                            name: it,
                            value: res.data[it]
                        });
                    }.bind(this));
                    this.isReady = true;
                    spyder.rerun(); 
                });
            },
            changeTheme($theme) {
                this.ops.theme = $theme;
                this.selectedTheme = $theme;
            },
            changeOptions() {
                this.$store.state.all.editor = this.ops;
                this.$eBus.$emit("changeOptions", this.ops);
            },
            changeView(view) {
                // this.views.map(function (it) {it.active = false});
                // view.active = true;
                this.$eBus.$emit("changeView", view);
            }
        }

    }
</script>