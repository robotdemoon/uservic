import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class FilterService {

  getSelected(opt, item = '') {
    const opts = opt.filter(opt => opt.checked);
    let s = '';
    if(item != ''){
      for (let x in opts) {
        s += opts[x][item]+',';
      }
      s = s.slice(0, -1);
    }else{
      s = opts;
    }
    return s;
  }
}
