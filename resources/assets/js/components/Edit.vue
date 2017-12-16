<template>
    <div>
        <el-row>
            <p style="font-size: 20px">合同编辑</p>
        </el-row>
        <el-form ref="form" :model="form" label-width="110px" :label-position="'left'">
            <el-form-item label="合同ID">
                <el-input disabled v-model="form.id" placeholder="为空时则新增"></el-input>
            </el-form-item>
            <el-form-item label="项目名称">
                <el-input v-model="form.project_name"></el-input>
            </el-form-item>
            <el-form-item label="项目地址">
                <el-input v-model="form.address"></el-input>
            </el-form-item>
            <el-form-item label="合同总价">
                <el-input v-model="form.price"></el-input>
            </el-form-item>
            <el-form-item label="服务年限">
                <el-col style="width:300px">
                    <el-date-picker type="date" placeholder="开始日期" v-model="form.date_st" style="width: 100%;"></el-date-picker>
                </el-col>
                <el-col class="line" style="width:10px">-</el-col>
                <el-col style="width:300px">
                    <el-date-picker type="date" placeholder="结束日期" v-model="form.date_et" style="width: 100%;"></el-date-picker>
                </el-col>
            </el-form-item>
            </el-form-item>
            <el-form-item label="项目质量">
                <el-select v-model="form.quality">
                    <el-option label="优秀" value="优秀"></el-option>
                    <el-option label="良好" value="良好"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="项目单位联系人">
                <el-input v-model="form.contact_name"></el-input>
            </el-form-item>
            <el-form-item label="联系人电话">
                <el-input v-model="form.contact_tel"></el-input>
            </el-form-item>
            <el-form-item label="合同内容">
                <el-input v-model="form.pic"></el-input>
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
                form: {
                    id: '',
                    project_name: '',
                    address: '',
                    price: '',
                    date_st: '',
                    date_et: '',
                    time: '',
                    quality: '',
                    contact_name: '',
                    contact_tel: '',
                    pic: ''
                }
            }
        },
        methods: {
            onSubmit() {
                console.log(this.form);
            }
        }
    }
</script>