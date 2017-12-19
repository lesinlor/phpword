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
                <el-form-item label="评审编号">
                    <el-input v-model="form.number"></el-input>
                </el-form-item>
                <el-form-item label="地区">
                    <el-input v-model="form.address"></el-input>
                </el-form-item>
                <el-form-item label="项目类型">
                    <el-select v-model="form.type">
                        <el-option :label="'全部'" :value="'0'"></el-option>
                        <el-option :label="'保安'" :value="'保安'"></el-option>
                        <el-option :label="'物业'" :value="'物业'"></el-option>
                        <el-option :label="'清洁'" :value="'清洁'"></el-option>
                        <el-option :label="'环卫'" :value="'环卫'"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="场所">
                    <el-select v-model="form.site">
                        <el-option :label="'学校'" :value="'学校'"></el-option>
                        <el-option :label="'医院'" :value="'医院'"></el-option>
                        <el-option :label="'政府'" :value="'政府'"></el-option>
                        <el-option :label="'办公楼'" :value="'办公楼'"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="时间">
                    <el-date-picker type="date" v-model="form.st" value-format="yyyy-MM-dd"></el-date-picker>
                    <span> - </span>
                    <el-date-picker type="date" v-model="form.et" value-format="yyyy-MM-dd"></el-date-picker>
                </el-form-item>
                <el-form-item label="时长">
                    <el-select v-model="form.sop">
                        <el-option v-for="(item, key) in compare" :key="key" :label="item" :value="key"></el-option>
                    </el-select>
                    <el-input v-model="form.section" placeholder="以月为单位"></el-input>
                </el-form-item>
                <el-form-item label="金额">
                    <el-select v-model="form.mop">
                        <el-option v-for="(item, key) in compare" :key="key" :label="item" :value="key"></el-option>
                    </el-select>
                    <el-input v-model="form.money"  placeholder="以元为单位"></el-input>
                </el-form-item>
                <el-form-item label="默认排序">
                    <el-select v-model="form.name">
                        <el-option :label="'金额'" :value="'price'"></el-option>
                        <el-option :label="'开始时间'" :value="'st'"></el-option>
                        <el-option :label="'结束时间'" :value="'et'"></el-option>
                        <el-option :label="'时长'" :value="'time'"></el-option>
                    </el-select>
                    <el-select v-model="form.sort">
                        <el-option :label="'升序'" :value="'asc'"></el-option>
                        <el-option :label="'降序'" :value="'desc'"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="信息列表">
                    <el-checkbox-group v-model="form.field">
                        <el-checkbox label="name" name="field">项目名</el-checkbox>
                        <el-checkbox label="sign" name="field">签约方</el-checkbox>
                        <el-checkbox label="address" name="field">地址</el-checkbox>
                        <el-checkbox label="money" name="field">金额</el-checkbox>
                        <el-checkbox label="number" name="field">编号</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-button type="primary" size="mini" class="marginTop" @click="onSubmit">搜索</el-button>
            </el-form>
        </el-card>
        <el-row class="marginTop">
            <draggable v-model="data">
                <div v-for="item in data" class="drag-table">{{item.name}}</div>
            </draggable>
        </el-row>
        <el-button type="primary" class="marginTop" @click="onSubmit">导出</el-button>
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
                    get: '/api/table/list',
                    exp: ''
                },
                form: {
                    number: '',
                    address: '',
                    site: '',
                    type: '0',
                    st: '',
                    et: '',
                    section: '',
                    sop: 'gt',
                    money: '',
                    mop: 'gt',
                    name: '',
                    sort: 'asc',
                    field: []
                },
                data: [],
                compare: {
                    gt: '>',
                    lt: '<',
                    // eq: '='
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
                console.log(this.form);
                this.reloadData()
            },
            reloadData() {
                let params = {
                    params: this.form
                }
                axios.get(this.api.get, params).then(res => {
                    this.data = res.data.data
                })
            }
        },
        created() {
            this.reloadData()
        }
    }
</script>

<style scoped>
    .marginTop {
        margin-top: 10px;
    }
    .el-form-item {
        margin-bottom: 10px;
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
