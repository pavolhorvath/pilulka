import React from "react"

export default class Settings extends React.Component
{
	state = {
		keyWords: [
			'#pilulka',
			'pilulka.cz'
		],
		tweetsCount: 10,
	}
	keyWordRef = React.createRef()

	handleTweetsCountChange = (e) => {
		let tweetCount = e.target.value
		if (tweetCount < 1) {
			tweetCount = 1
		} else if (tweetCount > 100) {
			tweetCount = 100
		}
		this.setState({
			tweetsCount: tweetCount
		})
	}

	handleKewWordRemoveClick = (index) => {
		let keyWords = this.state.keyWords
		delete keyWords[index]
		keyWords = keyWords.filter(function(keyWord) {
			return keyWord
		})
		this.setState({
			keyWords: keyWords
		})
	}

	handleKeyWordAddClick = () => {
		let keyWord = this.keyWordRef.current.value
		if (keyWord) {
			let keyWords = this.state.keyWords
			keyWords.push(keyWord)
			this.setState({
				keyWords: keyWords
			})
			this.keyWordRef.current.value = ''
		}
	}

	handleGetTweetsClick = () => {
		let keyWords = this.state.keyWords
		let tweetsCount = this.state.tweetsCount
		this.props.getTweets(keyWords, tweetsCount)
	}

	render() {

		return (
			<div className="tweet-settings-wrapper">
				<div className="key-words-wrapper">
					{this.state.keyWords.map((keyWord, index) => {
						return (
							<span className="key-word-wrapper" key={index}>
								<span className="key-word">{keyWord}</span>
								<span className="key-word-remove" title="Odstrániť"><i className="icon fas fa-window-close" onClick={() => this.handleKewWordRemoveClick(index)} /></span>
							</span>
						)
					})}
				</div>

				<div className="key-word-input-wrapper">
					<label>Kľúčové slovo:</label>
					<input type="text" name="kewWord" ref={this.keyWordRef} />
					<span className="button key-word-add-button" onClick={this.handleKeyWordAddClick}>Pridať</span>
				</div>

				<div className="tweets-count-wrapper">
					<label>Počet tweetov na zobrazenie</label>
					<input type="number" min="1" max="100" value={this.state.tweetsCount} onChange={this.handleTweetsCountChange}/>
				</div>

				<div className="get-tweets-button-wrapper">
					<span className="button get-tweets-button" onClick={this.handleGetTweetsClick}>Zobraziť tweety</span>
				</div>
			</div>
		)
	}
}