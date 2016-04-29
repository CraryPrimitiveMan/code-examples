var p2 = new Promise(function (resolve, reject) {
  const a = 100
  var p1 = new Promise(function (resolve, reject) {
    setTimeout(() => resolve(a), 3000)
  })
  setTimeout(() => resolve(p1), 1000)
})

var p3 = new Promise(function (resolve, reject) {
  setTimeout(() => resolve(4444), 3000)
})

Promise.all([p2, p3]).then(function (posts) {
  console.log(posts)
  return posts
}).then(function (posts) {
  console.log(1)
  console.log(posts)
  return new Promise(function (resolve, reject) {
    setTimeout(() => resolve(3333), 1000)
  })
}).then(function (posts) {
  console.log(2)
  console.log(posts)
}).catch(function(reason){
  // ...
});

// [100, 4444]
// 1
// [100, 4444]
// 2
// 3333
