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
            <el-form-item label="签约方">
                <el-input v-model="form.signature"></el-input>
            </el-form-item>
            <el-form-item label="合同单价">
                <el-input v-model="form.per_money"></el-input>
            </el-form-item>
            <el-form-item label="评审编号">
                <el-input v-model="form.batch"></el-input>
            </el-form-item>
            <el-form-item label="物业面积">
                <el-input v-model="form.area"></el-input>
            </el-form-item>
            <el-form-item label="单位面积">
                <el-input v-model="form.area_unit"></el-input>
            </el-form-item>
            <el-form-item label="分管情况">
                <el-input v-model="form.charge"></el-input>
            </el-form-item>
            <el-form-item label="标的情况">
                <el-input v-model="form.subject"></el-input>
            </el-form-item>
            <el-form-item label="场所">
                <el-input v-model="form.place"></el-input>
            </el-form-item>
            <el-form-item label="备注">
                <el-input v-model="form.comment"></el-input>
            </el-form-item>
            <el-form-item label="上传图片">
                <!-- <el-upload
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
                </el-upload> -->
                <el-upload
                  class="upload-demo"
                  drag
                  :data="imgId"
                  :disabled="false"
                  action="/api/img/upload"
                  multiple
                  :on-success="uploadSuccess">
                  <i class="el-icon-upload"></i>
                  <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                  <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>
            <el-form-item label="合同内容">
                <draggable v-model="form.fileList">
                    <div v-for="item in form.fileList" class="drag-table"><img class="draggable-img" :src="item"/></div>
                </draggable>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">保存</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default{
        components: {
            draggable,
        },
        data() {
            return {
                api: {
                    get: '/api/table/detail',
                    store: '/api/table/store',
                    edit: '/api/table/edit',
                    imgStore: '/api/img/store'
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
                    telephone: '',
                    signature: '',
                    per_money: '',
                    batch: '',
                    area: '',
                    area_unit: '',
                    charge: '',
                    subject: '',
                    place: '',
                    comment: '',
                    token: '',
                    fileList: []
                },
            }
        },
        methods: {
            onSubmit() {
                let api = this.form.id ? this.api.edit : this.api.store
                axios.post(api, qs.stringify(this.form)).then(res => {
                    console.log(this.form.fileList.length > 0);

                    // 新增
                    if( !this.form.id && res.data.code === 0){
                        this.form.id = res.data.id
                        this.form.token = res.data.token
                        this.$message({
                            message: '保存成功，继续添加图片',
                            type: 'success'
                        });
                    }else if (res.data.code === 0){
                        // this.$message({message: '添加成功',type: 'success'});
                        this.$alert('修改成功', '消息', {
                            confirmButtonText: '返回',
                            // callback: action => {
                            //     this.$router.push({path: '/manage'})
                            // }
                        });
                    }
                    else{
                        this.$message({message: '请填写完整',type: 'warning'});
                    }
                    console.log(this.form.fileList.length > 0);
                    // 提交图片接口
                    if(this.form.fileList.length > 0){
                        axios.post(this.api.imgStore, qs.stringify(this.imgParams)).then(res => {
                            console.log(res);
                        })
                    }
                }).catch(res => {
                    this.$message({message: '请填写完整',type: 'warning'});
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
            },
            uploadSuccess(res, file, fileList) {
                console.log(res);
                console.log(this.form.fileList);
                this.form.fileList.push(res.data)
            }
        },
        computed: {
            imgId() {
                return {id: this.form.id}
            },
            imgParams() {
                return {
                    id: this.form.id,
                    files: this.form.fileList
                }
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
                    for(let i in res.data.data)
                        this.form[i] = res.data.data[i]
                    this.form.fileList = []
                })
            }
        }
    }
</script>

<style scoped>
    .draggable-img{
        width: 400px;
        cursor: move;
    }
</style>
