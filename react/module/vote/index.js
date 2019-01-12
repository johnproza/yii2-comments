import React,{Component} from "react";
import ReactDOM from 'react-dom';

let topCount = 0;
let topId = 0;

export default class Vote extends Component {

    constructor(props){
        super(props);
        this.state = {
            id:this.props.id, //id элемента
            like:this.props.like,
            containerId:0,
            dislike:this.props.dislike,
            //status:false
        }

        console.log('www');
    }


    handleClick = (e) => {

        if(e.currentTarget.classList.contains('like')){
            this.setState({
                like: ++this.state.like
            })
        }
        else {
            this.setState({
                dislike: ++this.state.dislike
            })
        }

        this.props.update(this.state.id, this.state.like, this.state.dislike);

    }


    handleMessage = (e) => {
        this.props.message('Только авторизованные пользователи могут оценивать информацию')
    }


    render(){
        console.log('render --------- vote');
        return (
            <div>
                <i onClick={this.props.userCan ? this.handleClick : this.handleMessage} className="icon like ion-md-thumbs-up" data-type="true"><span>{this.state.like}</span></i>
                <i onClick={this.props.userCan ? this.handleClick : this.handleMessage} className="icon dislike ion-md-thumbs-down" data-type="true"><span>{this.state.dislike}</span></i>
            </div>
        )
    }

    componentDidMount(){
        this.setState({
            containerId: ReactDOM.findDOMNode(this).parentNode,
            id: ReactDOM.findDOMNode(this).parentNode.getAttribute('data-id'),
            like: ReactDOM.findDOMNode(this).parentNode.getAttribute('data-like') !="" ? ReactDOM.findDOMNode(this).parentNode.getAttribute('data-like') : 0 ,
            dislike: ReactDOM.findDOMNode(this).parentNode.getAttribute('data-dislike') ? ReactDOM.findDOMNode(this).parentNode.getAttribute('data-dislike') : 0,
            status:true
        });
    }

    componentDidUpdate(prevProps) {
        // if(this.state.status) {
        //     this.findTop()
        // }
    }
}