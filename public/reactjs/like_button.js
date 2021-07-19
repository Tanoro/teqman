
'use strict';

const e = React.createElement;

class LikeButton extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			error: null,
			isLoaded: false,
			items: []
		};
	}

	componentDidMount() {
		fetch('/ajax/test')
			.then(res => res.json())
			.then(
			(result) => {
				this.setState({
					isLoaded: true,
					items: result.items
				});
			},
			// Note: it's important to handle errors here
			// instead of a catch() block so that we don't swallow
			// exceptions from actual bugs in components.
			(error) => {
				this.setState({
					isLoaded: true,
					error
				});
			}
		)
	}

	render() {
		const { error, isLoaded, items } = this.state;

		if (error) {
			return <p>Error: {error.message}</p>;
		} else if (!isLoaded) {
			return <p>Loading...</p>;
		} else {
			return (
			<p>{success}</p>
			);
		}
	}
}

const domContainer = document.querySelector('#like_button_container');
ReactDOM.render(e(LikeButton), domContainer);
