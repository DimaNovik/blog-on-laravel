module.exports = {

    devServer: {
        proxy: 'http://blog'
    },

    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].title = 'Нотаріат Одеської області. Калькулятор додаткових послуг'
                return args
            })
    },

    outputDir: '../public',

    indexPath: process.env.NODE_ENV === 'production'
        ? '../resources/views/pages/calculator.blade.php'
        : 'index.html'
}




























