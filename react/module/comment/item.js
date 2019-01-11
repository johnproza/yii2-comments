import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Vote from '../vote/index';

export default class Item extends Component {

    constructor(props) {
        super(props);
        this.state = {

        }
    }

    render() {
        //return <this.props.react />
        return (
            <div className={this.props.classElem} data-id={this.props.data.id} data-parent={this.props.data.parent}>
                <div className="user">
                    <img src="/uploads/logo/52/Qv0a-DR6lwaA.png" alt="testtest" />
                </div>
                <div className="message">
                    <div className="systemCommnet">
                        <div className="authorInfo">
                            <b>{this.props.data.created_by}</b><span>{new Date(this.props.data.created_at*1000).toLocaleString()}</span>
                        </div>
                        <div className="like vote" data-id={this.props.data.id} data-parent={this.props.data.parent} data-like={this.props.data.like}
                             data-dislike={this.props.data.dislike}>
                            <Vote update={this.props.data.update} />

                        </div>
                    </div>
                    <div className="post">
                        {this.props.data.content}
                    </div>
                </div>
            </div>
        )
    }
}