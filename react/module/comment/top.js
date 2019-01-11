import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Ajax from './../../module/ajax/index'

export default class Top extends Component {

    constructor(props) {
        super(props);
        this.state = {
            element: this.props.element,
            parent: null,
            top: null,
            url : document.getElementById('allComments').getAttribute('data-entity'),
            //url : encodeURI(document.getElementById('appComments').getAttribute('data-entity').split("=")[1]),
            portal: true,
        }
    }

    render() {
        //return <this.props.react />
        return (
            <div>
                <div className="itemComment parent" data-id="9" data-parent="0">
                    <div className="user">
                        <img src="/uploads/logo/52/Qv0a-DR6lwaA.png" alt="testtest" />
                    </div>
                    <div className="message">
                        <div className="systemCommnet">
                            <div className="authorInfo">
                                <b>testtest</b>
                                7 дня назад <i className="icon ion-md-create" data-type="edit" data-id="9"></i>
                            </div>
                            <div className="like vote" data-id="9" data-parent="0" data-like="65" data-dislike="2">

                                <div><i className="icon like ion-md-thumbs-up" data-type="true"><span>65</span></i><i
                                    className="icon dislike ion-md-thumbs-down" data-type="true"><span>2</span></i>
                                </div>
                            </div>
                        </div>
                        <div className="post">
                            asdasdasdasdasd
                        </div>
                    </div>
                </div>
            </div>
        )
        //return ReactDOM.createPortal('',document.getElementById('topComments'))
    }

    componentDidMount() {
        this.getData()
    }

    componentDidUpdate() {
        //document.getElementById('topComments').innerHTML="";
        //document.getElementById('topComments').insertAdjacentElement('afterBegin',this.props.element);
    }


    getData = (url) =>{

        console.log(this.state.url);
        Ajax({
            "url":'/comments/default/get-top',
            "method":'GET',
            "csrf":true,
            "headers": 0, //Показать заголовки ответа
            "data":{entity:this.state.url}
        }).then(res =>{
            this.setState({
                parent : res.response.parent,
                top:res.response.top
            })

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res.response);
            }
        })
    }
}