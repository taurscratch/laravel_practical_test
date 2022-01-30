import React from 'react';
import ReactDOM from 'react-dom';
import Index from '.';

function Example() {
    return (
       <Index/>
    );
}

export default Example;

if (document.getElementById('index')) {
    ReactDOM.render(<Example />, document.getElementById('index'));
}
