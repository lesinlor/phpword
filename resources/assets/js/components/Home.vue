<template>
    <el-container>
        <el-header>
            <el-menu
                class="el-menu-demo"
                mode="horizontal"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b">
                <el-menu-item index="3" @click="handleLogout">退出登录</el-menu-item>
                <el-menu-item index="2">修改密码</el-menu-item>
                <el-menu-item index="1">你好，{{user.nickname}}</el-menu-item>

            </el-menu>
        </el-header>
        <el-container>
            <el-aside width="200px">
                <el-menu
                        default-active="manage"
                        class="el-menu-vertical-demo">
                    <el-menu-item
                        index="admin"
                        @click="$router.push({path: '/admin'})"
                        v-if="user.role_id == 1 || user.role_id == 2">
                        <i class="el-icon-menu"></i>
                        <span slot="title">用户管理</span>
                    </el-menu-item>
                    <el-menu-item index="manage" @click="$router.push({path: '/manage'})">
                        <i class="el-icon-setting"></i>
                        <span slot="title">合同管理</span>
                    </el-menu-item>
                    <el-menu-item index="export" @click="$router.push({path: '/export'})">
                        <i class="el-icon-setting"></i>
                        <span slot="title">合同导出</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>
            <el-main>
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    export default{
        data() {
            return {
                api: {
                    logout: '/api/logout'
                },
                user: {
                    nickname: '陈智',
                    role_id: '1'
                }
            }
        },
        methods: {
            handleLogout() {
                axios.post(this.api.logout).then(res => {
                    console.log(res);
                    if(res.data.code === 0){
                        this.$router.push({path: '/login'})
                    }
                })
            }
        },
        created() {
            axios.get('/api/session').then( res => {
                this.user = res.data.data
                console.log(this.user.role_id);
            })
        }
    }
</script>

<style scoped>
    .el-header{
        padding:0;
    }
    .el-menu--horizontal .el-menu-item{
        float: right;
    }
</style>
