var components = {
    "packages": [
        {
            "name": "jquery",
            "main": "jquery-built.js"
    },
        {
            "name": "jquery-cookie",
            "main": "jquery-cookie-built.js"
    }
    ],
    "baseUrl": "components"
};
if (typeof require !== "undefined" && require.config) {
    require.config(components);
} else {
    var require = components;
}
if (typeof exports !== "undefined" && typeof module !== "undefined") {
    module.exports = components;
}