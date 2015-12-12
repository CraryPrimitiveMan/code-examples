import './component.css';
import React from 'react';

// export default class Hello extends React.Component {
//   render() {
//     return <h1>Hello world3333333</h1>;
//   }
// }

export default React.createClass({
  render: function () {
    return (
      <div className="MyComponent-wrapper">
        <h1>Hello world</h1>
      </div>
    )
  }
});
