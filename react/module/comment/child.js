import React,{Component} from "react";
import Item from "./item";
import Ajax from "../ajax";

export default class Child extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data : this.props.data,
            showForm : this.props.form,
            totalShow : 3,
            showMore: true
        }
    }

    render() {
        var count = this.props.data.length - 3;
        if(count<=0) {count = null}
        return (

            <div>
                {this.props.data.map((child,j)=>
                this.state.totalShow > j ?
                    <Item data={child}
                          ajax = {Ajax}
                          userCan={this.props.userCan}
                          message={this.props.message}
                          submit = {this.props.submit}
                          vote={this.props.vote}
                          form = {false}
                          classElem={'itemComment child'}
                          // key={this.state.topId==child.id ? this.state.topItemKey : j}
                          key={j}
                          update={this.props.update} />:null

                )}
                {this.state.showMore && this.state.data.length >3 ? <div onClick={this.dataToggle} className={'showAllChild'}>Показать еще {count}</div> : null}
            </div>

        )
    }


    // componentWillReceiveProps(prevProps, prevState) {
    //
    //     if(this.props.form!=this.state.showForm){
    //         setTimeout(() => {
    //             this.setState({
    //                 showForm: this.props.form,
    //             });
    //         },3000)
    //
    //     }
    // }



    dataToggle = () =>{
        console.log(222);
        this.setState(()=> {
            return {totalShow:this.props.data.length,
                    showMore : false}
        })
    }






}