import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Base from './module/base.js';

// import('./module/base').then(Base =>{
//     ReactDOM.render(<Base />,document.getElementById('topComments'));
// })


ReactDOM.render(<Base />,document.getElementById('allComments'))


//Array.prototype.forEach.call(vote,(elem,i)=>ReactDOM.render(<Vote />,elem));


