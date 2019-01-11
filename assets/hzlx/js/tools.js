function Tools() {
    this.winWidth = Number,
    this.winHeight = Number
}

Tools.prototype = {
    constructor:Tools,
    dimensions:function(){ //获取窗口尺寸
        var w = Number
        var h = Number
        // 获取窗口宽度
        if (window.innerWidth){
            w = window.innerWidth;
        } else if ((document.body) && (document.body.clientWidth)){
            w = document.body.clientWidth;
        }
        // 获取窗口高度
        if (window.innerHeight){
            h = window.innerHeight;
        } else if ((document.body) && (document.body.clientHeight)){
            h = document.body.clientHeight;
        }

        // 通过深入 Document 内部对 body 进行检测，获取窗口大小
        if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth){
            h = document.documentElement.clientHeight;
            w = document.documentElement.clientWidth;
        }
        this.winWidth = w
        this.winHeight = h
    },
    resize:function(){ //响应式布局重置
        this.dimensions()
        var dom = this.getDom('html')
        if (this.winWidth > 640 ) {
                dom.style.fontSize = '100px'
        }else{
            dom.style.fontSize = this.winWidth / 6.4 + 'px'
        }
    },
    getDom:function(el){ //获取dom
        return document.querySelector(el)
    },
    varType:function(val){ //数据类型
        return Object.prototype.toString.call(val).slice(8,-1)
    },
    init:function(){
        this.resize()
        this.getDom('html').setAttribute('lang','zh_CN')
        window.addEventListener('resize',this.resize.bind(this))
    },
} 
window.addEventListener('load',new Tools().init()) 
