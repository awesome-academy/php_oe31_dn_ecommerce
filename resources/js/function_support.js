const convertVnd = function (arg, suffix) {
    var str = arg.toString();
    var length = str.length;
    var counter = 3;
    var result = "";
    while (length - counter >= 0) {
        var con = str.substr(length - counter, 3);
        result = "," + con + result;
        counter = counter + 3;
    }
    var con2 = str.substr(0, 3 - (counter - length));
    result = con2 + result;
    if (result.substr(0, 1) == ",") {
        result = result.substr(1, result.length + 2);
    }
    result = result + suffix;
    return result;
}
export { convertVnd };
