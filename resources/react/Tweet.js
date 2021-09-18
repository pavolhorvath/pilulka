import React from "react"

export default class Tweet extends React.Component
{
	render() {
		return (
			<div className="tweet-wrapper">
				<span className="tweet-author">{this.props.tweet.author}</span>
				<span className="tweet-text">{this.props.tweet.text}</span>
				<span className="tweet-created">{this.props.tweet.created}</span>
			</div>
		);
	}
}