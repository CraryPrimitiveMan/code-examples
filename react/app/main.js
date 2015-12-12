import React from 'react';
import Hello from './component.jsx';

import './main.css';

main();

function main() {
    React.render(<Hello className="hello" />, document.getElementById('app'));
}
