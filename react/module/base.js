import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Top from './comment/top';
import Vote from './vote/index';
import Ajax from './../module/ajax/index'
import Item from './comment/item'



export default class Base extends Component {

    constructor(props){
        super(props);
        this.state = {
            entity:document.getElementById('allComments').getAttribute('data-entity'),
            data:[],
            vote:true,
            elems:document.getElementsByClassName('vote'),
            topItemId : 5,
            showAll:false
        }

    }






    render(){
        //let elem = document.querySelector(`.parent[data-id="${this.state.topItemId}"]`);
        //let reactElem = React.createElement(elem.tagName,elem.attributes,elem.children);
        return (

            <div className="comments">


                {Array.prototype.map.call(
                    this.state.elems,(elem,i)=> ReactDOM.createPortal(<Vote update={this.update} key={++i}/>, elem)
                )}

                {ReactDOM.createPortal( <Top />, document.getElementById('topComments'))}
                {this.state.data.map((item,i)=>
                    <div className="parent" data-id={item.parent.id} key={i}>
                        <Item data={item.parent} classElem={'itemComment parent'} update={this.update} />
                        {/*<div className="itemComment parent" data-id={item.parent.id} data-parent={item.parent.parent}>*/}
                            {/*<div className="user">*/}
                                {/*<img src="/uploads/logo/52/Qv0a-DR6lwaA.png" alt="testtest" />*/}
                            {/*</div>*/}
                            {/*<div className="message">*/}
                                {/*<div className="systemCommnet">*/}
                                    {/*<div className="authorInfo">*/}
                                        {/*<b>{item.parent.created_by}</b><span>{new Date(item.parent.created_at*1000).toLocaleString()}</span>*/}
                                    {/*</div>*/}
                                    {/*<div className="like vote" data-id={item.parent.id} data-parent={item.parent.parent} data-like={item.parent.like}*/}
                                         {/*data-dislike={item.parent.dislike}>*/}
                                        {/*<Vote update={this.update} />*/}

                                    {/*</div>*/}
                                {/*</div>*/}
                                {/*<div className="post">*/}
                                    {/*{item.parent.content}*/}
                                {/*</div>*/}
                            {/*</div>*/}
                        {/*</div>*/}
                        {item.child.length!=0 ?

                                item.child.map((child,j)=>
                                    <Item data={child} classElem={'itemComment child'} update={this.update} />
                                )


                        :null}
                    </div>
                )}


                {!this.state.showAll ?
                <div className="showAllComments" onClick={this.getAllData}>
                    Показать все комментарии
                </div> : null}
            </div>
        )
    }

    componentDidMount(){
        this.setState({
            vote:false
        })

    }

    getAllData = () =>{
        Ajax({
            "url":'/comments/default/get-all',
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
                console.log('------get all list company data-------',res.response);
            }
        })
    }

    update = (id,like,dislike) => {

        this.setState({
            topItemId:id,
            render:false
        })

        console.log(this.state.topItemId,'----top id ----', id);

    }

}