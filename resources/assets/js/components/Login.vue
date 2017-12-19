<template>
    <div>
        <el-card class="box-card login-cont">
            <p>登录</p>
            <el-form :model="form" :rules="rules" ref="ruleForm" label-position="left" label-width="0px">
                <el-form-item prop="user" class="login-item">
                    <el-input
                        placeholder="请输入用户名"
                        v-model="form.username">
                    </el-input>
                </el-form-item>
                <el-form-item prop="password" class="login-item">
                    <el-input
                        type="password"
                        placeholder="请输入密码"
                        v-model="form.password"
                        @keyup.enter.native="handleSubmit">
                    </el-input>
                </el-form-item>
                <!--<el-form-item prop="code" class="login-item">-->
                    <!--<el-input-->
                            <!--placeholder="请输入用户名"-->
                            <!--v-model="form.code">-->
                    <!--</el-input>-->
                <!--</el-form-item>-->
                <el-button type="primary" @click="handleSubmit">登录</el-button>
            </el-form>
        </el-card>

    </div>
</template>

<script>
    import qs from 'qs';
    export default{
        data() {
            return {
                api: '/api/login',
                form: {
                    username: '',
                    password: '',
                    code: ''
                },
                rules: {
                    username: [{
                        required: true,
                        message: '请输入用户名',
                        trigger: 'blur'
                    }, ],
                    password: [{
                        required: true,
                        message: '请输入密码',
                        trigger: 'blur'
                    }, ],
//                    code: [{
//                        required: true,
//                        message: '请输入验证码',
//                        trigger: 'blur'
//                    }]
                },
            }
        },
        methods: {
            handleSubmit() {
                axios.post(this.api, qs.stringify(this.form)).then(res => {
                    console.log(res);
                    if(res.data.data){
                        this.$router.push({path: '/manage'});
                    }else{
                        this.$message.error(res.data.message);
                    }
                })
            },
            getCode() {

            }
        },
        created() {

        }
    }
</script>

<style>
    .login-cont{
        width: 600px;
        margin: 0 auto;
        margin-top: 300px;
    }
    .login-item{
        margin: 20px 0;
    }
</style>
