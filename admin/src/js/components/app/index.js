import React from 'react'

import Header from 'components/header';

export default class App extends React.Component {
    render() {
        return <div className="wrapper">
            <Header />
            <div className="container-fluid">
                {this.props.children}
            </div>
            <div className="footer"></div>
        </div>
    }
}
