<template>
    <div id="user-tab" class="text-center bg-dark">
        <div class="text-white-dark p-1 heading-ter d-b" style="background: #384148;">
            Creator
        </div>
        <div class="text-center my-2">
            <img :src="'/uploads/' + user.profile.image" class="user-image" alt="">
        </div>
        <h3 class="heading-ter text-prime">
            <a :href="'/by/user/' + user.username" class="text-prime" style="text-decoration: none;">{{user.name}}</a>
        </h3>
        <p class="my-2 p-1 mute text-left">
            {{user.profile.meta}}
        </p>
        <div class="class mt-2" v-if="tags.length > 0">
            <h4 class="heading-ter mb-2 w-10 text-left text-white mute">Tags</h4>
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