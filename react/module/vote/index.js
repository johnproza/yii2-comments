import React,{Component} from "react";
import ReactDOM from 'react-dom';

let topCount = 0;
let topId = 0;

export default class Vote extends Component {

    constructor(props){
        super(props);
        this.state = {
            id:0, //id элемента
            like:0,
            containerId:0,
            dislike:0,
            status:false
        }

        console.log('www');
    }

    findTop = () => {
        console.log(this.state.like,this.state.dislike )
        if((+this.state.like) + (+this.state.dislike) > topCount) {
            topCount = +this.state.like + +this.state.dislike;
            topId = this.state.id;
            this.props.update(topId);
        }

        {
            this.state.status ? this.setState({
                status:false
            }) : null
        }
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

        this.findTop();

    }

    render(){
        console.log('render');
        return (
            <div>
                <i onClick={this.handleClick} className="icon like ion-md-thumbs-up" data-type="true"><span>{this.state.like}</span></i>
                <i onClick={this.handleClick} className="icon dislike ion-md-thumbs-down" data-type="true"><span>{this.state.dislike}</span></i>
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
        if(this.state.status) {
            this.findTop()
        }
    }
}