!function(){var n=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["layout-content"]=n({1:function(n,e,l,a,t,s,o){var r,u=null!=e?e:n.nullContext||{},i=l.helperMissing,c=n.lambda,d=n.escapeExpression;return"\t<div "+(null!=(r=(l.generateId||e&&e.generateId||i).call(u,{name:"generateId",hash:{context:o[1]},fn:n.program(2,t,0,s,o),inverse:n.noop,data:t}))?r:"")+' class="'+d(c(null!=o[1]?o[1].class:o[1],e))+'" style="'+d(c(null!=o[1]?o[1].style:o[1],e))+'" '+(null!=(r=l.each.call(u,null!=o[1]?o[1].params:o[1],{name:"each",hash:{},fn:n.program(4,t,0,s,o),inverse:n.noop,data:t}))?r:"")+">\n"+(null!=(r=l.if.call(u,null!=(r=null!=o[1]?o[1]["module-names"]:o[1])?r.abovecontent:r,{name:"if",hash:{},fn:n.program(6,t,0,s,o),inverse:n.noop,data:t}))?r:"")+"\t\t<div "+(null!=(r=(l.generateId||e&&e.generateId||i).call(u,{name:"generateId",hash:{group:"inner",context:o[1]},fn:n.program(2,t,0,s,o),inverse:n.noop,data:t}))?r:"")+' class="inner '+d(c(null!=(r=null!=o[1]?o[1].classes:o[1])?r.inner:r,e))+'" style="'+d(c(null!=(r=null!=o[1]?o[1].styles:o[1])?r.inner:r,e))+'">\n\t\t\t'+(null!=(r=(l.showmore||e&&e.showmore||i).call(u,null!=e?e.content:e,{name:"showmore",hash:{len:null!=o[1]?o[1]["content-maxlength"]:o[1]},data:t}))?r:"")+"\n\t\t</div>\n\t</div>\n"},2:function(n,e,l,a,t,s,o){return n.escapeExpression(n.lambda(null!=o[1]?o[1].id:o[1],e))},4:function(n,e,l,a,t){var s,o=n.escapeExpression;return" "+o((s=null!=(s=l.key||t&&t.key)?s:l.helperMissing,"function"==typeof s?s.call(null!=e?e:n.nullContext||{},{name:"key",hash:{},data:t}):s))+'="'+o(n.lambda(e,e))+'"'},6:function(n,e,l,a,t,s,o){var r,u=n.lambda,i=n.escapeExpression;return'\t\t\t<div class="abovecontent '+i(u(null!=(r=null!=o[1]?o[1].classes:o[1])?r.abovecontent:r,e))+'" style="'+i(u(null!=(r=null!=o[1]?o[1].styles:o[1])?r.abovecontent:r,e))+'">\n'+(null!=(r=l.each.call(null!=e?e:n.nullContext||{},null!=(r=null!=o[1]?o[1]["module-names"]:o[1])?r.abovecontent:r,{name:"each",hash:{},fn:n.program(7,t,0,s,o),inverse:n.noop,data:t}))?r:"")+"\t\t\t</div>\n"},7:function(n,e,l,a,t,s,o){var r;return null!=(r=(l.withModule||e&&e.withModule||l.helperMissing).call(null!=e?e:n.nullContext||{},o[2],e,{name:"withModule",hash:{},fn:n.program(8,t,0,s,o),inverse:n.noop,data:t}))?r:""},8:function(n,e,l,a,t,s,o){return"\t\t\t\t\t\t"+n.escapeExpression((l.enterModule||e&&e.enterModule||l.helperMissing).call(null!=e?e:n.nullContext||{},o[3],{name:"enterModule",hash:{},data:t}))+"\n"},compiler:[7,">= 4.0.0"],main:function(n,e,l,a,t,s,o){var r;return null!=(r=l.with.call(null!=e?e:n.nullContext||{},null!=e?e.dbObject:e,{name:"with",hash:{},fn:n.program(1,t,0,s,o),inverse:n.noop,data:t}))?r:""},useData:!0,useDepths:!0})}();