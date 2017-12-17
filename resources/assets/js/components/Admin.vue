<template>
    <div>
        <el-row>
            <p style="font-size: 20px">管理员</p>
        </el-row>
        <el-row class="marginTop">
            <el-button @click="handleAdd">新增用户</el-button>
        </el-row>
        <el-row class="marginTop">
            <el-table
                :data="userGroup"
                border
                style="width: 100%">
                <el-table-column
                    prop="id"
                    label="ID">
                </el-table-column>
                <el-table-column
                    prop="nickname"
                    label="姓名">
                </el-table-column>
                <el-table-column
                    prop="username"
                    label="用户名">
                </el-table-column>
                <el-table-column
                    prop="role_name"
                    label="角色">
                </el-table-column>
                <el-table-column label="操作">
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
        <el-dialog title="编辑用户" :visible.sync="dialogFormVisible">
            <el-form :model="editForm">
                <el-form-item label="用户ID" :label-width="formLabelWidth">
                    <el-input v-model="editForm.id" auto-complete="off" disabled></el-input>
                </el-form-item>
                <el-form-item label="姓名" :label-width="formLabelWidth">
                    <el-input v-model="editForm.nickname" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="用户名" :label-width="formLabelWidth">
                    <el-input v-model="editForm.username" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" :label-width="formLabelWidth">
                    <el-input type="password" v-model="editForm.password" auto-complete="off" placeholder="新增用户必填"></el-input>
                </el-form-item>
                <el-form-item label="角色权限" :label-width="formLabelWidth">
                    <el-select v-model="editForm.role_id">
                        <el-option label="管理员" value="2"></el-option>
                        <el-option label="员工" value="3"></el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="handleSave">保 存</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import qs from 'qs';
    export default{
        data() {
            return {
                api: {
                    get: '/api/user',
                    post: 'api/user'
                },
                userGroup: [{
                    id: '',
                    nickname: '',
                    username: '',
                    role_id: '',
                    role_name: ''
                }],
                editForm: {
                    id: '',
                    nickname: '',
                    username: '',
                    password: '',
                    role_id: ''
                },
                pagination: {
                    sum: 20
                },
                limit: 20,
                currentPage: 1,
                dialogFormVisible: false,
                formLabelWidth: '120px',
                isAdding: false
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
                this.isAdding = true
                for(var i in this.editForm){
                    this.editForm[i] = ''
                    this.dialogFormVisible = true
                }
            },
            handleEdit(index, row) {
                this.isAdding = false
                for(var i in row){
                    this.editForm[i] = row[i]
                }
                this.editForm.password = ''
                this.dialogFormVisible = true
            },
            handleDelete(index, row) {
                let api = this.api.post
                let form = row
                form.flag = 0
                this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(api, qs.stringify(form)).then(res => {
                        console.log(res);
                        this.reloadData()
                        this.$message({
                            type: 'success',
                            message: '删除成功!'
                        });
                    })

                })
            },
            handleSave() {
                let api = this.api.post
                this.dialogFormVisible = false
                axios.post(api, qs.stringify(this.editForm)).then(res => {
                    console.log(res);
                    this.reloadData()
                })
            },
            reloadData() {
                let api = this.api.get
                console.log(this.options);
                axios.get(api, qs.stringify(this.options)).then( res => {
                    this.userGroup = res.data.data
                })
            }
        },
        computed: {
            options() {
                return {
                    offset: (this.currentPage - 1) * this.limit,
                    limit: this.limit
                }
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
</style>