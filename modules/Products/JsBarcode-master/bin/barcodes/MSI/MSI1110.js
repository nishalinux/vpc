'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _MSI2 = require('./MSI.js');

var _MSI3 = _interopRequireDefault(_MSI2);

var _checksums = require('./checksums.js');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var MSI1110 = function (_MSI) {
	_inherits(MSI1110, _MSI);

	function MSI1110(string) {
		_classCallCheck(this, MSI1110);

		var _this = _possibleConstructorReturn(this, _MSI.call(this, string));

		_this.string += (0, _checksums.mod11)(_this.string);
		_this.string += (0, _checksums.mod10)(_this.string);
		return _this;
	}

	return MSI1110;
}(_MSI3.default);

exports.default = MSI1110;