import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);


let store = new Vuex.Store({
    state: {
        initial:  ``,
        libs: [],
        autoSave: false,
        all: {
            lib: [],
            fs: [],
            result: '',
            editor: {
                theme: {
                    name: "vs-dark",
                    value: "vs-dark"
                },
                fontSize: 18,
                scrollBeyondLastLine: true
            },
            activeView: "left-right"
        },
        allowSave: false
    },
    mutations: {
        
    },
    actions: {
        
    },
    getters: {
        
    }
});


export default store;