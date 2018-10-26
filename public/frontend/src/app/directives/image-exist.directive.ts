import { Directive, Input } from '@angular/core';

@Directive({
selector: 'img[default]',
host: {
    '[src]':'src'
    }
})
export class DefaultImage {
    @Input() src:string;
}