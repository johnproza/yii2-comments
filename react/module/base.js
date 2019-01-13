import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Top from './comment/top';
import Vote from './vote/index';
import Ajax from './../module/ajax/index'
import Item from './comment/item'
import Message from './comment/message'

export default class Base extends Component {

    constructor(props){
        super(props);
        this.state = {
            entity:document.getElementById('allComments').getAttribute('data-entity'),
            data:[],
            top:null,
            hideMessage:true,
            textMessage:'',
            elems:document.getElementsByClassName('vote'),
            topItemKey : 'top',
            topId : 0,
            showAll:false,
            userCan:true
        }

    }

    render(){

        return (

            <div className="comments">

                <Top topId={this.state.topItemKey}
                     userCan={this.state.userCan}
                     data={this.state.top}
                     message={this.message}
                     submit = {this.submit}/>

                {/*{ReactDOM.createPortal( <Top />, document.getElementById('topComments'))}*/}
                {this.state.data.map((item,i)=>
                    <div className="parent" data-id={item.parent.id} >
                        <Item data={item.parent}
                              ajax = {Ajax}
                              userCan={this.state.userCan}
                              message={this.message}
                              submit = {this.submit}
                              classElem={'itemComment parent'}
                              key={this.state.topId==parent.id ? this.state.topItemKey : i}
                              update={this.update} />
                        {item.child.length!=0 ?
                            item.child.map((child,j)=>
                                <Item data={child}
                                      ajax = {Ajax}
                                      userCan={this.state.userCan}
                                      message={this.message}
                                      submit = {this.submit}
                                      classElem={'itemComment child'}
                                      key={this.state.topId==child.id ? this.state.topItemKey : j}
                                      update={this.update} />
                            )
                        :null}
                    </div>
                )}


                {!this.state.showAll && this.state.top!=null?
                <div className="showAllComments" onClick={this.getAllData}>
                    Показать все комментарии
                </div> : null}

                {!this.state.hideMessage ? ReactDOM.createPortal(<Message text={this.state.textMessage} />,document.getElementById('topComments')) : null}
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
            if(res.response.status){
                this.setState({
                    top : res.response,
                    topId : res.response.top.id
                })
            }


            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
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
                showAll:true
            })

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
        })

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
            }

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
        })

    }



}