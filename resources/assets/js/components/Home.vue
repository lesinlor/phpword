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
                <el-menu-item index="2" @click="handleEdit">修改密码</el-menu-item>
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
        <el-dialog title="修改密码" :visible.sync="dialogFormVisible" width="400px">
          <el-form :model="form">
            <el-form-item label="新密码" :label-width="'80px'">
              <el-input type="password" v-model="form.password" auto-complete="off"></el-input>
            </el-form-item>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleSubmit">确 定</el-button>
          </div>
        </el-dialog>
    </el-container>
</template>

<script>
    export default{
        data() {
            return {
                api: {
                    logout: '/api/logout',
                    edit: '/api/user'
                },
                user: {
                    nickname: '',
                    role_id: ''
                },
                form: {
                    id: '',
                    password: ''
                },
                dialogFormVisible: false
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
            },
            handleEdit() {
                this.dialogFormVisible = true
            },
            handleSubmit() {
                let api = this.api.edit
                axios.post(api, qs.stringify(this.form)).then(res => {
                    if(res.data.code == 0){
                        this.dialogFormVisible = false
                        this.$message({
                            message: '修改密码成功！',
                            type: 'success'
                        });
                    }else{
                        this.$message.error('修改失败！');
                    }
                })
            }
        },
        created() {
            axios.get('/api/session').then( res => {
                this.user = res.data.data
                this.form.id = res.data.data.user_id
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
