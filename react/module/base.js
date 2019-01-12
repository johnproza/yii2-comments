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
            hideMessage:true,
            textMessage:'',
            elems:document.getElementsByClassName('vote'),
            topItemKey : '',
            showAll:false,
            userCan:true
        }

    }

    render(){

        return (

            <div className="comments">

                {/*{this.state.userCan?*/}
                    {/*Array.prototype.map.call(*/}
                        {/*this.state.elems,(elem,i)=>*/}
                            {/*ReactDOM.createPortal(*/}
                                {/*<Vote update={this.update}*/}
                                      {/*userCan={this.state.userCan}*/}
                                      {/*message={this.message}*/}
                                      {/*key={++i}/>, elem)*/}
                {/*): null}*/}

                {/*{ReactDOM.createPortal( <Top />, document.getElementById('topComments'))}*/}
                {this.state.data.map((item,i)=>
                    <div className="parent" data-id={item.parent.id} key={i}>
                        <Item data={item.parent}
                              ajax = {Ajax}
                              userCan={this.state.userCan}
                              message={this.message}
                              classElem={'itemComment parent'}
                              update={this.update} />
                        {item.child.length!=0 ?
                            item.child.map((child,j)=>
                                <Item data={child}
                                      ajax = {Ajax}
                                      userCan={this.state.userCan}
                                      message={this.message}
                                      classElem={'itemComment child'}
                                      key={j}
                                      update={this.update} />
                            )
                        :null}
                    </div>
                )}


                {!this.state.showAll ?
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
            console.log('then top')
            // this.setState({
            //     top : [...res.response.data],
            //     showAll:false
            // })

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
                showAll:false
            })

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
        })
        this.removeOldData()
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



}