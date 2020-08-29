



const Movie = function() {
}

Movie.prototype.sayHello = () => {
  return "hello"
}

exports.Movie = Movie
module.exports = Movie

console.log(module.exports, exports) 
