// https://beholdr.github.io/maska
import { MaskInput } from "maska";

export default defineNuxtPlugin(async (nuxtApp) => {
    nuxtApp.vueApp.directive("maska", {
        presets: {
            money: {
              mask: "9.99#,##",
              reversed: true,
              tokens: { 9: { pattern: /[0-9]/, repeated: true } },
            },
            phone: {
              mask: ["(##) ####-####", "(##) #####-####"],
            },
            cpf: {
              mask: "###.###.###-##",
            },
            cnpj: {
              mask: "##.###.###/####-##",
            },
          },
      
          getMask(mask) {
            if (typeof mask == "string") {
              if (typeof this.presets[mask] == "undefined") {
                return { mask };
              }
              return this.presets[mask];
            }
      
            if (Array.isArray(mask)) {
              mask = mask.map((maskItem) => {
                if (this.presets[maskItem] && this.presets[maskItem]["mask"]) {
                  return this.presets[maskItem]["mask"];
                }
                return maskItem;
              });
      
              return { mask };
            }
      
            return mask;
          },
      
          mounted(el, bind, vnode, prevVnode) {
            if (!bind.value) return;
            const input = el.tagName == "INPUT" ? el : el.querySelector("input");
            bind.dir.maska = new MaskInput(input, bind.dir.getMask(bind.value));
          },
    });
});