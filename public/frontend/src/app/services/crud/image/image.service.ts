import { Injectable } from '@angular/core';
import { CrudService } from '../crud.service';

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  constructor(
    private crud: CrudService
  ) { }
  
  /**
   * [Actualizar Imagen]
   * @param event 
   * @param image_obj 
   * @param t 
   * @param id 
   */
  
  updateImage(event: any, id: number = 0, nameImage: string = 'nopicture.jpg'){
    let files = event.srcElement.files[0];
    if(files != undefined){
      if(Number(files['size']) > 1500000 || (files['type'] != 'image/jpeg' && files['type'] != 'image/png')) {
        console.log('Only pictures in format jpg/png and less than 1.5 Mb');
        return false;
      }else{
        let image = new FormData();
        image.append('image', files);
        return this.crud.image(['user', ( (id != 0) ? 'services' : 'perfil' )], image, ((id != 0) ? {'service': id, 'nameImage': nameImage}: {'nameImage': nameImage}));
      }
    }else{
      return false;
    }
  }

  /**
   * [Verificar si hay Imagen]
   * @param event 
   */

  verigyImage(event:any){
    let files = event.srcElement.files[0];
    let i = new FormData();
    if(files != undefined){
      if(Number(files['size']) > 1500000 || (files['type'] != 'image/jpeg' && files['type'] != 'image/png')) {
        console.log('Only pictures in format jpg/png and less than 1.5 Mb');
      }else{
        //this.image_name = '../general/load.gif';
        i.append('image', files);
      }
    }else{
      i.append('image', '');
    }
    return i;
  }

  generate(){
    return '?' + Math.floor(Math.random() * (1000000 - 1000) + 1000);
  }
}
