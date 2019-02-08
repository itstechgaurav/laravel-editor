<template>
    <div id="user-tab" class="text-center">
        <div class="text-center my-2">
            <img :src="'/uploads/' + user.profile.image" class="user-image" alt="">
        </div>
        <h3 class="heading-ter text-prime">
            <a :href="'/by/user/' + user.username" class="text-prime link link-white">{{user.name}}</a>
        </h3>
        <p class="p-1 my-2 mute text-justify">
            {{user.profile.meta}}
        </p>
        <hr>
        <div class="class mt-2">
            <h3 class="heading-ter mb-2 w-10 text-left text-white mute">Tags</h3>
            <div class="class space-b d-f" style="flex-wrap: wrap;">
                <a 
                    :href="'/by/tag/' + tag.name" 
                    style="text-decoration: none;"
                    class="mb-1"
                    v-for="(tag,index) in tags" :key="index">
                        <span class="badge badeg-white">
                            {{tag.name}}
                        </span>
                    </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'tags'],
        methods: {

        }
    }
</script>