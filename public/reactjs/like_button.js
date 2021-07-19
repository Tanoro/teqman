'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var e = React.createElement;

var LikeButton = function (_React$Component) {
	_inherits(LikeButton, _React$Component);

	function LikeButton(props) {
		_classCallCheck(this, LikeButton);

		var _this = _possibleConstructorReturn(this, (LikeButton.__proto__ || Object.getPrototypeOf(LikeButton)).call(this, props));

		_this.state = {
			error: null,
			isLoaded: false,
			items: []
		};
		return _this;
	}

	_createClass(LikeButton, [{
		key: 'componentDidMount',
		value: function componentDidMount() {
			var _this2 = this;

			var postBody = {
				type: "hot",
				limit: 10
			};
			var requestMetadata = {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(postBody)
			};

			fetch('/ajax/test', requestMetadata).then(function (res) {
				return res.json();
			}).then(function (result) {
				_this2.setState({
					isLoaded: true,
					items: result.items
				});
			},
			// Note: it's important to handle errors here
			// instead of a catch() block so that we don't swallow
			// exceptions from actual bugs in components.
			function (error) {
				_this2.setState({
					isLoaded: true,
					error: error
				});
			});
		}
	}, {
		key: 'render',
		value: function render() {
			var _state = this.state,
			    error = _state.error,
			    isLoaded = _state.isLoaded,
			    items = _state.items;


			if (error) {
				return React.createElement(
					'p',
					null,
					'Error: ',
					error.message
				);
			} else if (!isLoaded) {
				return React.createElement(
					'p',
					null,
					'Loading...'
				);
			} else {
				return React.createElement(
					'p',
					null,
					success
				);
			}
		}
	}]);

	return LikeButton;
}(React.Component);

var domContainer = document.querySelector('#like_button_container');
ReactDOM.render(e(LikeButton), domContainer);