<template>
    <el-container>
        <el-header>
            <el-menu
                class="el-menu-demo"
                mode="horizontal"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b">
                <el-menu-item index="3"><a href="https://www.ele.me" target="_blank">退出登录</a></el-menu-item>
                <el-menu-item index="2">修改密码</el-menu-item>
                <el-menu-item index="1">你好，{{user.name}}</el-menu-item>

            </el-menu>
        </el-header>
        <el-container>
            <el-aside width="200px">
                <el-menu
                        default-active="manage"
                        class="el-menu-vertical-demo">
                    <el-menu-item index="admin" @click="$router.push({path: '/admin'})">
                        <i class="el-icon-menu"></i>
                        <span slot="title">用户登录</span>
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
                user: {
                    name: '陈智',
                    role_id: '1'
                }
            }
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