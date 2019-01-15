import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Vote from '../vote/index';
import Ajax from "../ajax";
import Form from "./form";

export default class Item extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data : this.props.data,
            showForm : this.props.form,
        }
    }

    render() {
        //return <this.props.react />
        return (
            <div className={this.props.classElem} data-id={this.state.data.id} data-parent={this.state.data.parent}>
                <div className="user">
                    <img src="/uploads/logo/52/Qv0a-DR6lwaA.png" alt="testtest" />
                </div>
                <div className="message">
                    <div className="systemCommnet">
                        <div className="authorInfo">
                            <b>{this.state.data.created_by}</b><span>{new Date(this.state.data.created_at*1000).toLocaleString()}</span>
                            {this.props.userCan ? <span  className={'answer'} onClick={this.formToggle}>Ответить</span> : null }
                        </div>
                        <div className="like vote" data-id={this.state.data.id} data-parent={this.state.data.parent} data-like={this.state.data.like}
                             data-dislike={this.state.data.dislike}>
                            {<Vote update={this.updateItem}
                                      id={this.state.data.id}
                                      like={this.state.data.like}
                                      dislike={this.state.data.dislike}
                                      userCan={this.props.userCan}
                                      message={this.props.message}
                                />}
                        </div>
                    </div>
                    <div className="post">
                        {this.props.data.content}
                    </div>
                </div>

                {this.state.showForm ? <Form submit={this.props.submit } hide={this.formHide}/>:null}
            </div>
        )
    }


    // componentWillReceiveProps(prevProps, prevState) {
    //     console.log('componentDidUpdate')
    //         //if(prevState.)
    //         this.setState({showForm: this.props.form});
    //
    //     // if(prevProps.someValue!==this.props.someValue){
    //     //     //Perform some operation here
    //     //     this.setState({someState: someValue});
    //     //     this.classMethod();
    //     // }
    // }

    updateItem = (id,like,dislike) =>{
        Ajax({
            "url":`/comments/default/vote`,
            "method":'GET',
            "csrf":true,
            "data":{
                "id":id,
                "like":like,
                "dislike":dislike,
            }
        }).then(res =>{
            if(res.response.status){
                this.props.message(res.response.message)
            }
            else {
                this.props.message(res.response.message)
            }

            console.log('------data-------',id,like,dislike);

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res.response);
            }
        })
    }

    formToggle = () =>{

        this.setState(()=> {
            return {showForm:true}
        })
    }

    formHide = () =>{

        this.setState(()=> {
            return {showForm:false}
        })
    }

    // sendForm =(e)=> {
    //     e.preventDefault();
    //     let form = new FormData(e.currentTarget); //e.currentTarget
    //     let id = e.currentTarget.parentNode.getAttribute('data-id');
    //     let parent = e.currentTarget.parentNode.getAttribute('data-parent');
    //     if(form.get('content')==0){
    //         this.props.message('Форма не может быть пустой')
    //     }
    //     console.log(this.props.submit(form.get('content'),id,parent))
    // }


}