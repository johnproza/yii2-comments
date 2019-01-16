import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Top from './comment/top';
import Vote from './vote/index';
import Ajax from './../module/ajax/index';
import Child from './comment/child'
import Item from './comment/item';
import Message from './comment/message';
import Preloader from './comment/preloader';
import Form from './comment/form';

export default class Base extends Component {

    constructor(props){
        super(props);
        this.state = {
            entity:document.getElementById('allComments').getAttribute('data-entity'),
            data:[],
            top:null,
            hideMessage:true,
            totalShow : 3,
            textMessage:'',
            elems:document.getElementsByClassName('vote'),
            topItemKey : 'top',
            topId : 0,
            previewData:null,
            showAll:false,
            userCan:true,
            preloader:true
        }

    }

    render(){
        const data = this.state.data.length!=0 ? this.state.data : this.state.previewData;
        console.log('--------- rende data const --------',data)
        return (

            <div className="comments">
                {this.state.previewData == null ? <p>Комментариев пока не найдено</p> : null}
                {this.state.preloader ? <Preloader /> :
                    <div>

                    <Top topId={this.state.topItemKey}
                         userCan={this.state.userCan}
                         data={this.state.top}
                         message={this.message}
                         submit = {this.submit} />



                    {/*{ReactDOM.createPortal( <Top />, document.getElementById('topComments'))}*/}
                    {data!=null ? data.map((item,i)=>
                        <div className="parent" data-id={item.parent.id} >
                            <Item data={item.parent}
                                  ajax = {Ajax}
                                  userCan={this.state.userCan}
                                  message={this.message}
                                  submit = {this.submit}
                                  form = {false}
                                  classElem={'itemComment parent'}
                                  key={this.state.topId==parent.id ? this.state.topItemKey : i}
                                  update={this.update} />
                            {item.child.length!=0 ?
                                <Child data = {item.child}
                                       ajax = {Ajax}
                                       userCan={this.state.userCan}
                                       message={this.message}
                                       submit = {this.submit}
                                       form = {false}
                                       update={this.update}
                                />
                            :null}
                            {/*{this.state.hideAll && item.child.length!=0 ? <div onClick={this.showMore}>{'Показать больше'}</div> :null}*/}
                        </div>
                    ):null}


                    {!this.state.showAll && this.state.top!=null?
                    <div className="showAllComments" onClick={this.getAllData}>
                        Показать все комментарии
                    </div> : null}

                    {this.state.userCan ?
                        <div className={'itemComment'} data-id={0} data-parent={0}>
                            <Form submit={this.submit} message={this.message} text = {'Оставить комментарий'} />
                        </div> : null }

                    {!this.state.hideMessage ? ReactDOM.createPortal(<Message text={this.state.textMessage} />,document.getElementById('topComments')) : null}
                    </div>
                }
            </div>

        )
    }

    componentDidMount(){
        Ajax({
            "url":`/comments/default/can`,
            "method":'GET',
            "csrf":true,
        }).then(res =>{
            this.setState({
                userCan : res.response.can,
            })
            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res.response);
            }

            console.log('then 1')
            return true

        }).then((info)=>{
            console.log('then 2')
            return Ajax({
                "url":`/comments/default/get-top`,
                "method":'GET',
                "csrf":true,
                "headers": 0, //Показать заголовки ответа
                "data":{entity:this.state.entity}
            })
        }).then(res =>{

            console.log('then 3')
            if(res.response.status && res.response.top!=null){
                this.setState({
                    top : res.response,
                    topId : res.response.top.id,
                    //preloader:false,
                })
            }


            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }

            return Ajax({
                "url":`/comments/default/get-preview`,
                "method":'GET',
                "csrf":true,
                "headers": 0, //Показать заголовки ответа
                "data":{entity:this.state.entity}
            })
        }).then((res)=>{
            console.log('then 4',res)

            if(res.response.status && res.response.data!=null){
                this.setState({
                    previewData : [...res.response.data]
                })
            }

            this.changePreloader();
        })

    }

    changePreloader = () =>{
        this.setState({
            preloader:false
        })
    }


    getAllData = () =>{
        Ajax({
            "url":`/comments/default/get-all`,
            "method":'GET',
            "csrf":true,
            "headers": 0, //Показать заголовки ответа
            "data":{entity:this.state.entity}
        }).then(res =>{

            this.setState({
                data : [...res.response.data],
                showAll:true,
                preloader:false
            })

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
        })

    }


    showMore = () => {
        console.log('more')
    }

    message = (m) =>{
        this.setState({
            hideMessage:false,
            textMessage:m
        })

        this.timeOut(3000)
    }

    removeOldData = () =>{
        document.getElementById('back-render').innerHTML='';
    }

    timeOut = (delay) =>{
        setTimeout(()=>{this.setState({hideMessage:true})
                    },delay)
    }

    submit = (data,id,parent) =>{

        Ajax({
            "url":`/comments/default/create`,
            "method":'POST',
            "csrf":true,
            "headers": 0, //Показать заголовки ответа
            "data":{
                entity:this.state.entity,
                content:data,
                parent:parent!=0 ? parent : id,
            }
        }).then(res =>{

            if(res.response.status){
                this.message(res.response.message);
                this.getAllData();

            }

            if(NODE_ENV==="development") {
                console.log('------get all listddddd company data-------',res);
            }
        })

    }





}