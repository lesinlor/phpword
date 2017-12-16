<template>
    <div>
        <el-card class="box-card login-cont">
            <p>登录</p>
            <el-form :model="form" :rules="rules" ref="ruleForm" label-position="left" label-width="0px">
                <el-form-item prop="user" class="login-item">
                    <el-input
                        placeholder="请输入用户名"
                        v-model="form.user">
                    </el-input>
                </el-form-item>
                <el-form-item prop="password" class="login-item">
                    <el-input
                            placeholder="请输入密码"
                            v-model="form.password">
                    </el-input>
                </el-form-item>
                <el-form-item prop="code" class="login-item">
                    <el-input
                            placeholder="请输入用户名"
                            v-model="form.code">
                    </el-input>
                </el-form-item>
                <el-button type="primary" @click="handleSubmit">主要按钮</el-button>
            </el-form>
        </el-card>

    </div>
</template>

<script>
    export default{
        data() {
            return {
                form: {
                    user: '',
                    password: '',
                    code: ''
                },
                rules: {
                    user: [{
                        required: true,
                        message: '请输入用户名',
                        trigger: 'blur'
                    }, ],
                    password: [{
                        required: true,
                        message: '请输入密码',
                        trigger: 'blur'
                    }, ],
                    code: [{
                        required: true,
                        message: '请输入验证码',
                        trigger: 'blur'
                    }]
                },
            }
        },
        methods: {
            handleSubmit() {

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