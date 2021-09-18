import React from "react"
import {CookiesProvider} from "react-cookie";
import Modal from "react-modal"
import axios from "axios";
import Settings from "./Settings";
import Tweet from "./Tweet";

Modal.setAppElement('#root');

export default class App extends React.Component
{
	state = {
		tweets: [],
		showLoader: false
	}

	getTweets = (keyWords, tweetsCount) => {
		this.setState({
			showLoader: true
		})
		axios.post('tweets', {keyWords: keyWords, tweetsCount: tweetsCount})
			.then(response => {
				this.setState({
					tweets: response.data,
					showLoader: false
				})
			})
	}

	render() {
		return (
			<CookiesProvider>
				<div className="app-wrapper">
					<Settings getTweets={this.getTweets} />

					<div className="tweets-wrapper">
						{this.state.tweets.map((tweet, index) => {
							return (
								<Tweet tweet={tweet} key={index} />
							)
						})}
					</div>

					<div id="loader" hidden={!this.state.showLoader}>
						<img src="/images/loader.gif" />
					</div>
				</div>
			</CookiesProvider>
		)
	}
}