<template>
    <div>
        <el-row>
            <p style="font-size: 20px"><el-button type="text" @click="$router.push({path: '/manage'})">返回上页</el-button>  >> 合同编辑</p>
        </el-row>
        <el-form ref="form" :model="form" label-width="110px" :label-position="'left'">
            <el-form-item label="合同ID">
                <el-input disabled v-model="form.id" placeholder="为空时则新增"></el-input>
            </el-form-item>
            <el-form-item label="项目名称">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="项目地址">
                <el-input v-model="form.address"></el-input>
            </el-form-item>
            <el-form-item label="合同总价">
                <el-input v-model="form.money"></el-input>
            </el-form-item>
            <el-form-item label="服务年限">
                <el-col style="width:300px">
                    <el-date-picker type="date" placeholder="开始日期" v-model="form.st" value-format="yyyy-MM-dd" style="width: 100%;"></el-date-picker>
                </el-col>
                <el-col class="line" style="width:10px">-</el-col>
                <el-col style="width:300px">
                    <el-date-picker type="date" placeholder="结束日期" v-model="form.et" value-format="yyyy-MM-dd" style="width: 100%;"></el-date-picker>
                </el-col>
            </el-form-item>
            </el-form-item>
            <el-form-item label="项目质量">
                <el-select v-model="form.grade">
                    <el-option label="优秀" :value="1"></el-option>
                    <el-option label="良好" :value="2"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="项目单位联系人">
                <el-input v-model="form.concat"></el-input>
            </el-form-item>
            <el-form-item label="联系人电话">
                <el-input v-model="form.telephone"></el-input>
            </el-form-item>
            <el-form-item label="合同内容">
                <el-upload
                    class="upload-demo"
                    action="/api/img/upload"
                    :on-preview="handlePreview"
                    :on-remove="handleRemove"
                    multiple
                    :limit="3"
                    :on-exceed="handleExceed"
                    :file-list="fileList">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="onSubmit">保存</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                api: {
                    get: '/api/table/detail',
                    store: '/api/table/store',
                    edit: '/api/table/edit'
                },
                form: {
                    id: '',
                    name: '',
                    address: '',
                    money: '',
                    st: '',
                    et: '',
                    grade: '',
                    concat: '',
                    telephone: ''
                },
                fileList: []
            }
        },
        methods: {
            onSubmit() {
                console.log(this.form);
                let api = this.form.id ? this.api.edit : this.api.store
                console.log(qs);
                axios.post(api, qs.stringify(this.form)).then(res => {
                    if (res.data.code === 0){
                        // this.$message({message: '添加成功',type: 'success'});
                        this.$alert('修改成功', '消息', {
                            confirmButtonText: '返回',
                            callback: action => {
                                this.$router.push({path: '/manage'})
                            }
                        });
                    }else{
                        this.$message({message: '请填写完整',type: 'warning'});
                    }
                })
            },
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`);
            }
        },
        created() {
            let id = this.$route.params.id
            console.log(id);
            if(id != 0){
                let params = {
                    params: {id: id}
                }
                axios.get(this.api.get, params).then(res => {
                    this.form = res.data.data
                })
            }
        }
    }
</script>
