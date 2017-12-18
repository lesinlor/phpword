<template>
    <div>
        <el-row>
            <p style="font-size: 20px">合同导出</p>
        </el-row>
        <el-card class="box-card marginTop">
            <el-form ref="form" :model="form" label-width="80px" :label-position="'left'">
                <el-row>
                    <p style="font-size: 16px">条件筛选</p>
                </el-row>
                <el-form-item label="地区">
                    <el-input v-model="form.address"></el-input>
                </el-form-item>
                <el-form-item label="项目类型">
                    <el-select v-model="form.type">
                        <el-option :label="'全部'" :value="'0'"></el-option>
                        <el-option :label="'保安'" :value="'sp'"></el-option>
                        <el-option :label="'物业'" :value="'pm'"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="时间">
                    <el-date-picker type="date" v-model="form.st"></el-date-picker>
                    <span> - </span>
                    <el-date-picker type="date" v-model="form.et"></el-date-picker>
                </el-form-item>
                <el-form-item label="时长">
                    <el-select v-model="form.time_op">
                        <el-option v-for="(item, key) in compare" :key="key" :label="item" :value="key"></el-option>
                    </el-select>
                    <el-input v-model="form.time" placeholder="以月为单位"></el-input>
                </el-form-item>
                <el-form-item label="金额">
                    <el-select v-model="form.price_op">
                        <el-option v-for="(item, key) in compare" :key="key" :label="item" :value="key"></el-option>
                    </el-select>
                    <el-input v-model="form.price"  placeholder="以元为单位"></el-input>
                </el-form-item>
                <el-form-item label="默认排序">
                    <el-select v-model="form.sort">
                        <el-option :label="'金额'" :value="'price'"></el-option>
                        <el-option :label="'开始时间'" :value="'st'"></el-option>
                        <el-option :label="'结束时间'" :value="'et'"></el-option>
                        <el-option :label="'时长'" :value="'time'"></el-option>
                    </el-select>
                    <el-select v-model="form.order">
                        <el-option :label="'金额'" :value="'price'"></el-option>
                        <el-option :label="'开始时间'" :value="'st'"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" size="mini" class="marginTop" @click="onSubmit">搜索</el-button>
            </el-form>
        </el-card>
        <el-row class="marginTop">
            <draggable v-model="data">
                <div v-for="item in data" class="drag-table">{{item.project_name}}</div>
            </draggable>
        </el-row>
        <el-button type="primary" class="marginTop" @click="onSubmit">保存</el-button>
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
                    get: '',
                    exp: ''
                },
                form: {
                    address: '',
                    type: '0',
                    st: '',
                    et: '',
                    time: '',
                    time_op: 'gt',
                    price: '',
                    price_op: 'gt',
                    sort: '',
                    order: '金额'
                },
                data: [{
                    id: '1',
                    project_name: '广州开发区公园及广场保安服务采购项目子项目1',
                    address: '广州开发区科学城揽月路',
                    price: '7919316.24',
                    date: '2017.1.1-2018.12.31',
                    time: '24',
                    quality: '优秀',
                    contact_name: '周永红',
                    contact_tel: '82227369'
                }, {
                    id: '1',
                    project_name: '广州开发区公园及广场保安服务采购项目子项目2',
                    address: '广州开发区科学城揽月路',
                    price: '7919316.24',
                    date: '2017.1.1-2018.12.31',
                    time: '24',
                    quality: '优秀',
                    contact_name: '周永红',
                    contact_tel: '82227369'
                }, {
                    id: '1',
                    project_name: '广州市流花湖公园保安服务',
                    address: '广州开发区科学城揽月路',
                    price: '7919316.24',
                    date: '2017.1.1-2018.12.31',
                    time: '24',
                    quality: '优秀',
                    contact_name: '周永红',
                    contact_tel: '82227369'
                }, {
                    id: '1',
                    project_name: '广州市流花湖公园保安服务2',
                    address: '广州开发区科学城揽月路',
                    price: '7919316.24',
                    date: '2017.1.1-2018.12.31',
                    time: '24',
                    quality: '优秀',
                    contact_name: '周永红',
                    contact_tel: '82227369'
                }],
                compare: {
                    gt: '>',
                    lt: '<',
                    eq: '='
                }
            }
        },
        methods: {
            handleSearch() {
                console.log(this.form);
            },
            onSubmit() {
                let id = ''
                for(let i in this.data){
                    id += this.data[i].id + ','
                }
                console.log(id);
                this.reloadData()
            },
            reloadData() {
                let params = {
                    params: this.form
                }
                axios.get(this.api.get, params).then(res => {
                    console.log(res);
                })
            }
        }
    }
</script>

<style>
    .marginTop {
        margin-top: 10px;
    }
    .drag-table{
        border: 1px solid #eaecef;
        padding: 10px;
        cursor: move;
    }
    .el-input{
        width: 180px;
    }
</style>