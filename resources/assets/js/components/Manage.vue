<template>
    <div>
        <el-row>
            <p style="font-size: 20px">合同管理</p>
        </el-row>
        <el-row class="marginTop">
            <el-button @click="handleAdd">新增项目</el-button>
        </el-row>
        <el-row class="marginTop">
            <el-table
                    :data="data"
                    border
                    style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="project_name"
                        label="项目名称">
                </el-table-column>
                <el-table-column
                        prop="address"
                        label="项目地址">
                </el-table-column>
                <el-table-column
                        prop="price"
                        label="合同总价(元)">
                </el-table-column>
                <el-table-column
                        prop="date"
                        label="服务年限">
                </el-table-column>
                <el-table-column
                        prop="time"
                        label="服务时长(月)">
                </el-table-column>
                <el-table-column
                        prop="quality"
                        label="项目质量">
                </el-table-column>
                <el-table-column
                        prop="contact_name"
                        label="项目单位联系人">
                </el-table-column>
                <el-table-column
                        prop="contact_tel"
                        label="联系人电话">
                </el-table-column>
                <el-table-column label="操作" width="150px">
                    <template slot-scope="scope">
                        <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                        <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-row>
        <el-row class="marginTop">
            <el-pagination
                    layout="sizes, prev, pager, next"
                    :page-sizes="[20, 50, 100]"
                    :page-size="limit"
                    :current-page="currentPage"
                    :total="pagination.sum"
                    @current-change="turnPage"
                    default-value="2017-05-01 - 2017-05-10"
                    @size-change="setLimit">
            </el-pagination>
        </el-row>
    </div>
</template>

<script>
    export default{
        data() {
            return {
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
                }],
                pagination: {
                    sum: 20
                },
                limit: 20,
                currentPage: 1,
            }
        },
        methods: {
            turnPage(val) {
                this.currentPage = val
                this.reloadData()
            },
            setLimit(val) {
                this.limit = val
                this.currentPage = 1
                this.reloadData()
            },
            handleAdd() {
                this.editPact()
            },
            handleEdit(index, row) {
                this.editPact(row.id)
            },
            handleDelete() {
                this.$confirm('此操作将永久删除该项目, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                })
            },
            editPact(id) {
                if(id)
                    this.$router.push({path: '/edit/' + id});
                else
                    this.$router.push({path: '/edit/0'});
            },
            reloadData() {

            }
        },

        created() {
            this.data[1] = this.data[0]
            this.data[2] = this.data[0]
            this.data[3] = this.data[0]
            this.data[4] = this.data[0]
        }
    }
</script>

<style scoped>
    .marginTop {
        margin-top: 10px;
    }
</style>