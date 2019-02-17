<template>
    <div :id="ops.uId" class="w-10 editor-window"></div>
</template>

<script>
    import * as monacoCore from "monaco-editor";
    import * as axios from "axios";
    import { emmetHTML, emmetCSS } from 'emmet-monaco-es'

    export default {
        props: ['ops'],
        data() {
            return {
                themes: {
                    "vs-light": "vs-light",
                    "vs-dark": "vs-dark"
                }
            }
        },
        mounted() {
            this.editor = monacoCore.editor;
            let conf = {
                language: this.ops.lang,
                automaticLayout: true,
                autoIndent: true,
                theme: "vs-dark",
                fontSize: this.$store.state.all.editor.fontSize,
                fontFamily: "'Fira Mono', monospace",
                value: this.ops.content
            };
            this.cEditor = this.editor.create(document.getElementById(this.ops.uId), conf);
            this.listen();
            // this.cEditor.setValue(this.ops.content);
            this.changeOptions(this.$store.state.all.editor);
            this.$eBus.$on("changeTheme", this.changeTheme);
            this.$eBus.$on("changeOptions", this.changeOptions);

            if(this.ops.lang === 'html') {
                emmetHTML(this.cEditor, monacoCore);
            }

            if(this.ops.lang === 'css') {
                emmetCSS(this.cEditor, monacoCore);
            }
        },
        methods: {
            listen() {
                this.cEditor.onDidChangeModelContent(evt => {
                    this.ops.content = this.cEditor.getValue();
                    this.$eBus.$emit("fileChanges", this.ops);
                })
            },
            loadTheme(op, callback) {
                let $theme = op.theme;
                if(this.themes[$theme.name]) {
                    callback(op);
                } else {
                    axios.get("/themes/" + $theme.value + ".json").then(res => {
                        this.editor.defineTheme($theme.name, res.data);
                        callback(op);
                    })
                }
            },
            changeOptions(op) {
                this.loadTheme(op, function(op){
                    this.cEditor.updateOptions(op);
                    this.editor.setTheme(op.theme.name);
                }.bind(this));
            }
        }
    }
</script>