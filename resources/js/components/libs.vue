<template>
    <div id="libs-container">
        <div class="row space-a my-3">
            <div class="col-7 col-8-md col-10-sm col-12-xs">
                <div class="w-10 text-center">
                    <div class="link link-prime text-white mx-1 pointer" @click="showAll = false">Add</div>
                    <div class="link link-prime text-white mx-1 pointer" @click="showAll = true">Show All</div>
                </div>
            </div>
            <div class="col-6 col-8-md col-10-sm col-12-xs" id="libs-search-bar" v-if="!showAll">
                <input type="text" class="input-input" placeholder="Search any module (Jquery, bootstrap, vue)" v-model="qry">
                <div class="list libs-list" id="search-result">
                    <div class="list-item" v-for="(item, index) in searchedLibs" @click="selectLib(item.name)" :key="'statge-0' + index">{{item.name}}</div>
                </div>
                <div class="mt-3 list w-10 theme-white-dark" v-if="is.selected">
                    <div class="list-item bg-dark text-white-dark">{{selectedLib.name}}</div>
                    <div class="list-item">{{selectedLib.description}}</div>
                    <div class="list-item">
                        <div class="label">
                            Select Version
                        </div>
                        <div class="w-10">
                            <select class="input-input" name="" id="" @change="selectVersion($event)" v-model="version">
                                <option :value="item" v-for="(item, index) in selectedLib.assets" :key="'stage-1-' + index">{{item.version}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="list-item" v-if="is.version">
                        <label for="" class="label">Files For v({{version.version}})</label>
                        <div class="list w-10 text-dark">
                            <div class="list-item row" v-for="(file, index) in version.files" :key="'stage-2-' + index">
                                <div class="col-10">{{file.name}}</div>
                                <div class="col-2">
                                    <div class="btn btn-prime text-white ion ion-plus-round btn-s" @click="file.more = !file.more"></div>
                                </div>
                                <div class="col-12" v-if="file.more">
                                    <a class="w-10 text-ter" :href="`https://cdnjs.cloudflare.com/ajax/libs/${selectedLib.name}/${version.version}/${file.name}`">{{`https://cdnjs.cloudflare.com/ajax/libs/${selectedLib.name}/${version.version}/${file.name}`}}</a>
                                    <div class="class mt-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class="label w-10">Before or After</label>
                                                <select name="" id="" class="input-input" v-model="location">
                                                    <option value="b-css">before &lt;loadcss/&gt;</option>
                                                    <option value="a-css">after &lt;loadcss/&gt;</option>
                                                    <option value="b-js">before &lt;loadjs/&gt;</option>
                                                    <option value="a-js">after &lt;loadjs/&gt;</option>
                                                </select>
                                            </div>
                                            <div class="col-12 text-center">
                                                <div class="btn btn-prime" @click="addLib(file)">Add</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-6 col-8-md col-10-sm col-12-xs" v-if="showAll">
                <div class="list libs-list">
                    <div class="list-item" v-for="(item, index) in allLibs" :key="'stateg-4-' + index">
                        <div class="row">
                            <div class="col-10">
                                <a :href="item.url" class="text-ter">{{item.url}}</a>
                            </div>
                            <div class="col-2">
                                <div class="btn btn-s btn-warn ion ion-close-round text-white" @click="delLib(index)"></div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        data() {
            return {
                qry: '',
                showAll: false,
                allLibs: [],
                searchedLibs: [],
                selectedLib: {},
                version: {
                    version: '',
                    files: []
                },
                location: 'b-css',
                is: {
                    selected: false,
                    version: false,
                    addPanel: 'no'
                }
            }
        },
        watch: {
            qry: "search"
        },
        mounted() {
            this.allLibs = this.$store.state.all.lib;
        },
        methods: {
            search() {
                axios.get(`https://api.cdnjs.com/libraries?search=${this.qry}`).then(res => {
                    this.searchedLibs = res.data.results.slice(0, 10);
                }).catch(err => {
                    console.log("err: ", err);
                });
            },
            selectLib(name) {
                this.is.selected = false;
                this.is.version = false;
                axios.get(`https://api.cdnjs.com/libraries/${name}`).then(res => {
                    let data = res.data;
                    data.assets.map(function(item) {
                        item.files = this.renderFiles(item.files);
                        return item;
                    }.bind(this));
                    this.selectedLib = data;
                    this.version = data.assets[0];
                    this.is.version = true;
                    this.is.selected = true;
                }).catch(err => {
                    console.log("Error: ", err);
                });
            },
            selectVersion(e) {
                this.is.version = true;
            },
            renderFiles(files) {
                let fin = [];
                files.map(function(item) {
                    let isValid = false;
                    if(['css', 'js'].includes(item.split('.')[item.split('.').length -1])) {
                        isValid = true;
                    }
                    if(isValid) {
                        let abc = {};
                        abc.name = item;
                        abc.more = false;
                        fin.push(abc);
                    }
                });
                return fin;
            },
            addLib(file) {
                let lib = {
                    url: `https://cdnjs.cloudflare.com/ajax/libs/${this.selectedLib.name}/${this.version.version}/${file.name}`,
                    name: this.selectedLib.name,
                    version: this.version.version,
                    type: file.name.split('.')[file.name.split('.').length - 1],
                    location: this.location
                };

                let unique = true;

                this.$store.state.all.lib.map(function(item) {
                    if(item.url === lib.url) {
                        unique = false;
                    }
                })

                if(unique) {
                    this.$store.state.all.lib.push(lib);
                    file.more = false;
                    this.$eBus.$emit("lib-added");
                    addMsg("ter", `/${this.selectedLib.name}/${this.version.version}/${file.name}`);
                }
            },
            delLib(index) {
                this.$store.state.all.lib.splice(index, 1);
                this.$eBus.$emit("lib-deleted");
            }
        }
    }
</script>