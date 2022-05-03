

<input type="text" name="text"
               id="text" multiple size="50">
@push('push_scripts')
<script>
var allArrays = [
  ['red', 'black'],
  ['256'],
  ['M', 's', 'L']
]

function allPossibleCases(arr) {
  if (arr.length == 1) {
    return arr[0];
  } else {
    var result = [];
    var allCasesOfRest = allPossibleCases(arr.slice(1)); // recur with the rest of array
    for (var i = 0; i < allCasesOfRest.length; i++) {
      for (var j = 0; j < arr[0].length; j++) {
        result.push(arr[0][j] + allCasesOfRest[i]);
      }
    }
    return result;
  }

}

console.log(allPossibleCases(allArrays))
    </script>
@endpush