import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Item from './../../module/comment/item'

export default class Top extends Component {

    constructor(props) {
        super(props);
        console.log(this.props.data)
        this.state = {
            topId: this.props.topId,
            data:this.props.data,
            userCan:this.props.userCan,
            message:this.props.message
        }
    }

    render() {

        return (
            this.props.data!=null?
            <div className="topComment">

                <div className="parent" data-id={this.props.data.parent.id} >
                    <Item data={this.props.data.parent}
                          userCan={this.state.userCan}
                          message={this.props.message}
                          classElem={'itemComment parent'}
                          update={this.update} />
                    <div className="children best">
                         <Item data={this.props.data.top}
                          userCan={this.props.userCan}
                          message={this.props.message}
                          classElem={'itemComment child'}
                          update={this.update} key={this.props.topId} />
                    </div>
                </div>
            </div>:null

        )

    }



}