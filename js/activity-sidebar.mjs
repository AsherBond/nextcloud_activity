function __vite__mapDeps(indexes) {
  if (!__vite__mapDeps.viteFileDeps) {
    __vite__mapDeps.viteFileDeps = [OC.filePath('activity', '', 'js/ActivityTab.chunk.mjs'),OC.filePath('activity', '', 'js/NcCheckboxRadioSwitch-D2GbHtCS.chunk.mjs'),OC.filePath('activity', '', 'js/index.chunk.mjs'),OC.filePath('activity', '', 'js/_commonjsHelpers.chunk.mjs'),OC.filePath('activity', '', 'js/logger.chunk.mjs'),OC.filePath('activity', '', 'js/Activity.chunk.mjs'),OC.filePath('activity', '', 'js/api.chunk.mjs')]
  }
  return indexes.map((i) => __vite__mapDeps.viteFileDeps[i])
}
/*! third party licenses: js/vendor.LICENSE.txt */
import{V as m,t as v,a as g}from"./index.chunk.mjs";import"./_commonjsHelpers.chunk.mjs";const E="modulepreload",b=function(e,l){return e[0]==="."?new URL(e,l).href:e},h={},y=function(e,l,c){let u=Promise.resolve();if(l&&l.length>0){const s=document.getElementsByTagName("link"),t=document.querySelector("meta[property=csp-nonce]"),f=(t==null?void 0:t.nonce)||(t==null?void 0:t.getAttribute("nonce"));u=Promise.all(l.map(r=>{if(r=b(r,c),r in h)return;h[r]=!0;const a=r.endsWith(".css"),w=a?'[rel="stylesheet"]':"";if(c)for(let d=s.length-1;d>=0;d--){const p=s[d];if(p.href===r&&(!a||p.rel==="stylesheet"))return}else if(document.querySelector('link[href="'.concat(r,'"]').concat(w)))return;const o=document.createElement("link");if(o.rel=a?"stylesheet":E,a||(o.as="script",o.crossOrigin=""),o.href=r,f&&o.setAttribute("nonce",f),document.head.appendChild(o),a)return new Promise((d,p)=>{o.addEventListener("load",d),o.addEventListener("error",()=>p(new Error("Unable to preload CSS for ".concat(r))))})}))}return u.then(()=>e()).catch(s=>{const t=new Event("vite:preloadError",{cancelable:!0});if(t.payload=s,window.dispatchEvent(t),!t.defaultPrevented)throw s})},_='<svg xmlns="http://www.w3.org/2000/svg" id="mdi-lightning-bolt" viewBox="0 0 24 24"><path d="M11 15H6L13 1V9H18L11 23V15Z" /></svg>';m.prototype.t=v,m.prototype.n=g;let n=null,i=null;const A=new OCA.Files.Sidebar.Tab({id:"activity",name:v("activity","Activity"),iconSvg:_,async mount(e,l,c){if(n===null){const{default:u}=await y(()=>import("./ActivityTab.chunk.mjs"),__vite__mapDeps([0,1,2,3,4,5,6]),import.meta.url);n=n!=null?n:m.extend(u)}i&&i.$destroy(),i=new n({parent:c}),i.update(l),i.$mount(e)},update(e){i.update(e)},destroy(){i.$destroy(),i=null}});window.addEventListener("DOMContentLoaded",async function(){if(OCA.Files&&OCA.Files.Sidebar){OCA.Files.Sidebar.registerTab(A);const{default:e}=await y(()=>import("./ActivityTab.chunk.mjs"),__vite__mapDeps([0,1,2,3,4,5,6]),import.meta.url);n=n!=null?n:m.extend(e)}});export{_ as l};
