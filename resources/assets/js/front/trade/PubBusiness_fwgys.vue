<template>
	<div id='pub-business'>
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>交易</BreadcrumbItem>
                    <BreadcrumbItem to="/trade/platform">供求商讯</BreadcrumbItem>
                    <BreadcrumbItem to="/trade/Publish">免费发布信息</BreadcrumbItem>
                    <BreadcrumbItem>发布服务供应商</BreadcrumbItem>
                </Breadcrumb>
                <Row type="flex" :class-name="'add-cash'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'cash-box'">
                        <Form ref="step2" :model="step2" :rules="rules2" :label-width="120">
                            <FormItem label="标题:" prop="title">
                                <Input v-model="step2.title" size="large" style="width: 620px" placeholder="请输入发布标题" ></Input>
                            </FormItem>
                            <FormItem label="服务类型种类:">
                                <RadioGroup v-model="service_choice" :class="'common-radio'">
                                    <Radio v-for="(item,key) in bcategory[0]" :key="key" :label="item.id">{{item.cname}}</Radio>
                                </RadioGroup>
                            </FormItem>                            
                            <FormItem label="服务类型:" prop="payment">
                                <RadioGroup v-model="step2.payment" :class="'common-radio'">
                                    <Radio v-for="(item,key) in bcategory[service_choice]" :label="item.id" :key="key">{{item.cname}}</Radio>
                                </RadioGroup>
                            </FormItem>
                            <FormItem label="产品网址:" prop="url">
                                <Input v-model="step2.url" type="text" size="large"
                                       style="width: 620px" placeholder="请输入网址 例如：http://www.bcquan.com"></Input>
                            </FormItem>
                            <FormItem label="产品介绍:" prop="desc">
                                <quill-editor v-model="step2.desc" style="min-height: 5rem; border: 1px solid #e2e2e2;" :options="editorOption">
                                </quill-editor> 
                            </FormItem>                       
                            <FormItem label="产品照片:" prop="picture">
                                <ul class="trade-pictures">
                                    <li v-for="(item,key) in [0,1,2,3,4]" :key="key" @click="choice_pic(key)">
                                            <img v-if="step2.picture[key]" v-bind:src="step2.picture[key]">
                                            <img v-else src="/static/add_pic.png">           
                                    </li>
                                    <form id="choice-form">
                                        <input type="file" accept="image/jpeg,image/png,image/gif" id="choice-file" @change="onFileChange">
                                    </form>
                                </ul>
                                <ul>
                                    <li :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">500*300像素(最多上传五张图片)</li>
                                </ul>
                            </FormItem>
                            <div style="margin: 20px 0;background: #f2f2f2; line-height: 40px; border-left: 6px solid #ed8e18; text-align: left;">
                                <p style="color: #333; font-size: .28rem; padding-left: 8px;">联系人信息</p>
                            </div>
                            <FormItem label="联系人:" prop="contact">
                                <Input v-model="step2.contact" type="text" size="large"
                                       style="width: 620px" placeholder="请输入联系人名称"></Input>
                            </FormItem>
                            <FormItem label="联系电话:" prop="phone">
                                <Input v-model="step2.phone" type="text" size="large"
                                       style="width: 620px" placeholder="请输入您的联系电话"></Input>
                            </FormItem>
                            <FormItem label="联系Skype:" prop="skype">
                                <Input v-model="step2.skype" type="text" size="large"
                                       style="width: 620px" placeholder="请输入您的skype ID"></Input>
                            </FormItem>
                            <FormItem label="联系QQ:" prop="qq">
                                <Input v-model="step2.qq" type="text" size="large"
                                       style="width: 620px" placeholder="请输入您的QQ联系方式"></Input>
                            </FormItem>
                            <FormItem label="联系微信:" prop="weixin">
                                <Input v-model="step2.weixin" type="text" size="large"
                                       style="width: 620px" placeholder="请输入您的微信号"></Input>
                            </FormItem>
                            <p style="text-align: center">
                                <Button class="submit-button" @click="handleSubmit('step2')">提交</Button>
                                <Button class="submit-button preview-button" @click="preview=1;go_top()">预览</Button>
                            </p>
                        </Form>
                    </Col>
                </Row>
            </Col>
		</Row>
		<FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>			
        <Modal
            v-model="cropper.show_cropper"
            title="截取头像图片"
            @on-ok="get_picture"
            :ok-text="'截取'"
            :cancel-text="'取消'"
            :width="910">
            <vueCropper
                ref="cropper"
                :img="cropper.avatar"
                :autoCrop="cropper.autoCrop"
                :autoCropWidth="cropper.autoCropWidth"
                :autoCropHeight="cropper.autoCropHeight"
                :fixedBox="cropper.fixedBox" style="width:880px;height:500px;">                                 
            </vueCropper>
        </Modal>     
        <div class="preview" v-bind:class="{'preview-show':preview}">
            <Row type="flex" justify="center">
                <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">

                    <Row type="flex" justify="center">
                        <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                            <div class="close-preview">
                                <span class="pointer" @click="preview=0"><Icon type="ios-undo"></Icon> 关闭预览</span>
                            </div>  
                            <Row :class-name="'bns-detail'">
                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                                    <h2 class="bns-title">{{step2.title}}</h2>
                                    <div class="bns-type">
                                        <ul class="marks">
                                            <li><a>业务类型</a></li>
                                            <li>
                                                <a><!-- v-if="item.id==step2.paymnet" -->
                                                   <template v-for="(item,key) in bcategory[service_choice]" v-if="step2.payment==item.id">
                                                       {{item.cname}}
                                                   </template>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bns-content">
                                        <ul>
                                            <li v-for="(img,index) in step2.picture" v-if="img">
                                                <img :src="img" @error="remove(index)">
                                            </li>
                                        </ul>
                                        <div class="bns-article" v-html="step2.desc">
                                        </div>
                                    </div>
                                    <p class="bns-notice">
                                        <b>免责声明：</b>此信息由会员发布，请自行核实内容真实性，如产生任何纠纷本站对此不承担责任，官方认证信息除外。
                                    </p>                                    
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Col>
            </Row>            
        </div>             	
	</div>
</template>

<script>
import PageRight from '../components/MainRight.vue';	
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import $ from 'jquery';
import lrz from 'lrz';
import Vue from 'vue';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
import { quillEditor } from 'vue-quill-editor';
import check from '../common/check.js'
import VueCropper from 'vue-cropper'
let Option = { 
            placeholder: "添加发布内容！", 
            modules: {          
                toolbar: [
                  ['bold', 'italic', 'underline', 'strike',{ 'header': 1 }, { 'header': 2 }]
                ]
            }
        }
export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar,quillEditor,VueCropper},
	mounted(){
		document.title = '发布供求商讯| 服务供应商';
        var v = this
        var id = this.$route.query.id
        v.https.get('/front/trade/get_business_opt').then((r)=>{
            v.bcategory = r.data
            if (id) {
                v.https.get('/front/trade/get_detail',{params:{
                    id:id,
                    model:'Business'
                }}).then((r)=>{
                    v.step2.title = r.data.title
                    v.step2.url = r.data.url
                    v.step2.contact = r.data.contactperson
                    v.step2.phone = r.data.phone
                    v.step2.qq = r.data.qq
                    v.step2.skype = r.data.skype
                    v.step2.weixin = r.data.wechat
                    v.step2.desc = r.data.content
                    v.id = id
                    for (var i in v.bcategory) {
                        for (var j = 0; j < v.bcategory[i].length; j++) {
                            if (v.bcategory[i][j].id == r.data.bid) {
                                v.service_choice = v.bcategory[i][j].fid
                                var bid = v.bcategory[i][j].id
                            }
                            v.$nextTick(function () {
                                v.step2.payment = bid
                            })
                        }
                    }
                    for(var i in JSON.parse(r.data.pic)){
                        v.$set(v.step2.picture,i,JSON.parse(r.data.pic)[i])
                    }
                }).catch((e)=>{
                    console.log(e)
                })
            }
        }).catch((e)=>{
            console.log(e)
        })
	},
	data(){
		return {
            preview:0,
            id:'',
            cropper: {
                avatar: '',
                autoCrop: true,
                autoCropWidth: 500,
                autoCropHeight: 300,
                fixedBox: true,
                show_cropper:false
            },            
            title: '',
            image: '',
            addImgRange:'',
            bcategory:'',  
            service_choice:1,   
            editorOption:Option,
            picture_key:0,
            step2: {
                title: '',
                payment: '',
                url: '',
                desc: '',
                picture: [],
                contact: '',
                phone: '',
                skype: '',
                qq: '',
                weixin: '',
            },
            rules2: {
                title: [
                    { required: true, message: '发布标题不能为空', trigger: 'blur' }
                ],
                contact: [
                    { required: true,  message: '请输入联系人姓名', trigger: 'change' }
                ],
                phone: [
                    { required: true,  message: '请输入联系电话', trigger: 'change' }
                ],
                skype: [
                    { required: false,  message: '请输入skype', trigger: 'change' }
                ],
                weixin: [
                    { required: false,  message: '请输入联系人微信号', trigger: 'change' }
                ],
            }
		}
	},
	methods: {
        go_top(){
            document.documentElement.scrollTop = 0
        },
        handleSubmit (name) {
            var v = this
            this.$refs[name].validate((valid) => {
                if (valid) {
                    if (!v.step2.title.trim()||!v.step2.contact.trim()) {
                        v.$Message.error('请完善必填信息')
                        return false
                    }
                    if(!v.step2.payment){
                        v.$Message.error('请选择服务类型')
                        return false
                    }
                    if (v.step2.title.length>40) {
                        v.$Message.error('标题太长，请限制在40个字符之内')
                        return false
                    }
                    if (v.step2.contact.length>30) {
                        v.$Message.error('请输入合法姓名')
                        return false
                    }                    
                    if(!check.phone_check(v.step2.phone,v)){
                        return false
                    }
                    if(v.step2.skype&&!check.skype_check(v.step2.skype,v)){
                        return false
                    }                    
                    if(v.step2.qq&&!check.qq_check(v.step2.qq,v)){
                        return false
                    }
                    if(v.step2.weixin&&!check.wechat_check(v.step2.weixin,v)){
                        return false
                    }                     
                    v.https.post('/front/trade/business_publish',{
                        data:v.step2,
                        type:1,
                        id:v.id
                    }).then((r)=>{
                        if (r.data.code == 1) {
                            this.$Message.success('发布成功')                            
                            v.$router.push('/trade/PubSuccess/business')
                        }else{
                            this.$Message.error(r.data.msg);
                        }
                    }).catch((e)=>{
                        console.log(e)
                    })
                }
            })
        },
        choice_pic(key){
            this.picture_key = key
            $("#choice-file").click()
            var file = document.getElementById('choice-file')
        },
        onFileChange: function(e) {
            var file = e.target.files || e.dataTransfer.files;
            if(!file.length) return;
            var v = this
            lrz(file[0]).then((rst)=>{
                v.cropper.avatar = rst.base64
                v.cropper.show_cropper = true
            })
            $("#choice-form")[0].reset()
        },
        get_picture(){
            this.$refs.cropper.getCropData((data) => {
                let formdata = new window.FormData();
                formdata.append('picture',data);
                var func = function(v,path){
                    v.$set(v.step2.picture,v.picture_key,path)
                }
                this.uploadReq(formdata,func);              
            })      
        },     
        uploadReq(formdata,func){
            var vm =this;
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            };
            this.https.post('/front/trade/upload_picture',formdata, config).then(
                (res) => {
                    if (res.data.code == 1) {
                        func(vm,res.data.path)
                    } else {
                        vm.$Message.warning('更换图片失败')
                    }
                }).catch(
                (err) =>{
                    console.log(err);       
            });
        }          
	}
}
</script>
<style lang='scss' scoped>
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .ql-editor{
        min-height:5rem;
        border: 1px solid #e2e2e2;
    }
    .ql-toolbar.ql-snow + .ql-container.ql-snow {
        border-top: 0;
        min-height: 0;
    }
    #pub-business {
        position: relative;
        .preview{
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
            min-height: 100%;
            background-color: #fff;
            z-index: 10000;
            display: none;
            .container{
                width: 1200px;
                min-height: 60vh;
                .close-preview{
                    font-size: 18px;
                    margin-top: 20px;
                    padding-bottom: 20px;
                }
            .bns-detail {
                .bns-title {
                    font-size: .6rem;
                    color: #333;
                    font-weight: bold;
                }
                .bns-author {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                    padding: 10px 0;
                    margin-bottom: 20px;
                    >span {
                        display: inline-block;
                        font-size: .28rem;
                        color: #888;
                        margin-right: 15px;
                    }
                    .bns-name {
                        cursor: pointer;
                        max-width: 220px;
                    }
                }
                .bns-type {
                    border: 1px solid #f2f2f2;
                    background: #fbfbfb;
                    padding: 15px 10px 15px 20px;
                    margin-bottom: 20px;
                    ul:after {
                        content: '';
                        display: block;
                        clear: both;
                    }
                    .marks {
                        li {
                            float: left;
                            margin: 5px 0;
                            a {
                                display: block;
                                color: #666;
                                font-size: .26rem;
                                background: #ebf2fb;
                                text-decoration: none;
                                position: relative;
                                height: 26px;
                                line-height: 26px;
                                padding: 0 10px 0 10px;
                                text-align: center;
                                margin-right: 10px;
                                border: 1px dashed #a4c2ec;
                                border-radius: 3px;
                                //z-index: 2;
                            }
                        }
                        li:nth-child(1) a {
                            padding-left: 15px;
                            -webkit-border-radius: 3px 0 0 3px;
                            -moz-border-radius: 3px 0 0 3px;
                            -ms-border-radius: 3px 0 0 3px;
                            -o-border-radius: 3px 0 0 3px;
                            border-radius: 3px 0 0 3px;
                            background: #dae5f4;
                            color: #555;
                            font-weight: bold;
                            border: 1px solid #dae5f4;
                        }
                        li:nth-child(1) a:before {
                            content: "";
                            position: absolute;
                            right: -11px;
                            top: -1px;
                            width: 0;
                            height: 0;
                            border-top: 13px solid transparent;
                            border-left: 10px solid #dae5f4;
                            border-bottom: 13px solid transparent;
                        }
                        li:nth-child(2) a {
                            padding-left: 15px;
                            -webkit-border-radius: 0 3px 3px 0;
                            -moz-border-radius: 0 3px 3px 0;
                            -ms-border-radius: 0 3px 3px 0;
                            -o-border-radius: 0 3px 3px 0;
                            border-radius: 0 3px 3px 0;
                            border-color: #a4c2ec;
                            border-left-color: transparent;
                        }
                        li:nth-child(2) a:before {
                            content: "";
                            position: absolute;
                            left: -1px;
                            top: -1px;
                            width: 0;
                            height: 0;
                            border-top: 14px solid transparent;
                            border-left: 10px solid #fbfbfb;
                            border-bottom: 14px solid transparent;
                        }
                    }
                    .links {
                        display: block;
                        padding-top: 10px;
                        >li {
                            float: left;
                            padding: 8px 10px 0 0;
                            text-align: left;
                            font-size: .28rem;
                            margin-right: 15px;
                            a {
                                display: inline-block;
                                font-size: 14px;
                                color: #478dce;
                            }
                        }
                    }
                }
                .bns-content {
                    ul {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: flex-start;
                        align-items: center;
                        padding: 10px 0;
                        li{
                            margin-right: 10px;
                            img{
                                width: 150px;
                                height: 105px;
                                cursor: pointer;
                            }
                        }
                        li:last-child {
                            margin-right: 0;
                        }
                    }
                    .bns-article {
                        font-size: 16px;
                        color: #333;
                        white-space: pre-wrap;
                        text-align: justify;
                        margin-top: 10px;
                        padding: 10px;
                        overflow: hidden;
                        overflow-wrap: break-word;
                    }
                }
                .bns-notice {
                    margin: 30px 0 40px 0;
                    width: 100%;
                    line-height: 36px;
                    border: 1px solid #c59f5e;
                    background: #fcf8e3;
                    text-align: left;
                    padding: 5px 10px;
                    border-radius: 5px;
                    font-size: .26rem;
                    color: #c59f5e;
                    b {
                        color: #555;
                        font-weight: bold;
                        margin-right: 3px;
                    }
                }
            }                
            }
        }
        .preview-show{
            display: block;
        }           
        .container {
            width: 1200px;
            margin: 20px auto;
            min-height: 80vh;
            .quill-editor {
                border: 1px solid #ddd;
            }
            .add-cash {
                margin: 50px 0 30px 0;
                .cash-box {
                    font-size: .28rem;
                    width: 80%;
                    margin: 0 auto;
                }
                .trade-pictures{
                    display: flex;
                    li{
                        display: inline-block;
                        width: 150px;
                        position: relative;
                        height: 90px;
                        img{
                            cursor: pointer;
                            position: absolute;
                            top: 0px;
                            left: 0px;
                            width: 100%;
                            height: 100%;
                        }           
                    }                
                }
            }
            #choice-form{
                display: none;
            }
            /* pub_step1 */
            .lotteryNav {
                width: 100%;
                margin: 0 auto;
                padding: 8px 0;
                text-align: left;
                input[type=radio] {
                    margin-right: 10px;
                }
                .pubLi {
                    width: 950px;
                    line-height: 80px;
                    background: #fbfbfb;
                    margin: 20px 0;
                    padding: 20px 10px 20px 20px;
                    .regular-radio + label {
                        -webkit-appearance: none;
                        background-color: #fafafa;
                        border: 1px solid #cacece;
                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
                        padding: 9px;
                        border-radius: 50px;
                        display: inline-block;
                        position: relative;
                        vertical-align: middle;
                        right: 8px;
                        left: 10px;
                        top: 15px;
                    }
                    .regular-radio:checked + label:after {
                        content: ' ';
                        width: 12px;
                        height: 12px;
                        border-radius: 50px;
                        position: absolute;
                        top: 3px;
                        background: #28b28a;
                        box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3);
                        text-shadow: 0px;
                        left: 3px;
                        font-size: 32px;
                    }
                    .regular-radio:checked + label {
                        background-color: #fff;
                        color: #28b28a;
                        border: 1px solid #28b28a;
                        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1);
                    }
                    .regular-radio + label:active, .regular-radio:checked + label:active {
                        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
                    }
                    em {
                        font-style: normal;
                        font-size: .33rem;
                        font-weight: bold;
                        color: #333;
                        padding-left: 12px;
                    }
                    p {
                        font-size: .26rem;
                        font-weight: normal;
                        color: #333;
                        padding-left: 41px;
                    }
                }
            }

            /* pub_step2 */
           .submit-button {
                margin-left: 0;
                background-color: #28b28a;
                color: white;
            }
            .preview-button{
                background-color: rgb(242, 242, 242);
                color: #333;
            }
            /* pub_step3 */
            .pub-success {
                width: 80%;
                margin: 0 auto;
                list-style: none;
                text-align: center;
                padding: 100px;
                li {
                    display: inline-block;
                    height: 100px;
                }
                li:first-child {
                    overflow: hidden;
                    margin-right: 30px;
                    padding-top: 15px;
                    img {
                        width: 86px;
                        height: 86px;
                        display: block;
                    }
                }
                li:last-child {
                    padding-top: 10px;
                    text-align: left;
                    h2 {
                        font-size: .35rem;
                        font-weight: bold;
                        color: #333;
                        padding: 0 10px 10px 10px;
                    }
                    p {
                        padding: 0 10px 10px 10px;
                        font-size: .28rem;
                        color: #555;
                        span {
                            color: #ed8e18;
                            font-size: .3rem;
                            margin: 0 8px 0 0;
                        }
                        a {
                            color: #478dce;
                            text-decoration: underline;
                        }
                    }
                }
            }

        }
    }
</style>