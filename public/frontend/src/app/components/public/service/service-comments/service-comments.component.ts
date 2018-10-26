import { Component, Input, Output, EventEmitter, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
/**
 * [Importamos los Servicios]
 */

import { CrudService } from '../../../../services/crud/crud.service';
import { DesignService } from '../../../../services/global/design.service';
import { TokenService } from '../../../../services/tkn/token.service';
/**
 * [Importar Constantes]
 */

import { URL } from '../../../../constants/url.constant';
import { ServicepHelperService } from '../servicep-helper.service';

@Component({
  selector: 'app-service-comments',
  templateUrl: './service-comments.component.html',
  styleUrls: ['./service-comments.component.css']
})
export class ServiceCommentsComponent implements OnInit {
  public subData: Subscription;

  public url = URL.user;
  public image = '';
  public username = '';
  public comments = [];

  /**
   * [Variables Externas]
   */

  //@Input() public comments = [];
  @Input() public idService = '';
  @Input() public id = '';
  @Input() public status = false;
  @Output() public ncomments = new EventEmitter<number>();

  constructor(
    private crud: CrudService,
    private design: DesignService,
    private servicepHelper: ServicepHelperService,
    private tkn: TokenService
  ) {
  }

  ngOnInit() {
  }

  ngOnChanges(){
    this.getComments();
    let d = this.tkn.getDataTkn();
    this.image = d.image;
    this.username = d.username;
  }

  getComments(){
    this.servicepHelper.getComments(this.idService).subscribe(d => {this.comments = d.comm; this.ncomments.next(+d.n + 1 );})
  }


  sendComment(msg: string, answer: number = 0){
    let c = {service: this.id, answer: +answer, msg: msg};
    this.subData = this.crud.implements(['user', 'comments', 'add'], 0, c ).subscribe(
      (d) => {
        let date = (new Date()).toDateString();
        if(d.e == false){
          if(+answer != 0){
            const p = this.comments.indexOf(this.comments.filter(h => h.id == answer)[0]);
            this.comments[p].elements.push({id: +d.id, answer: +answer, image: this.image, username: this.username, date: date, msg: msg, elements: []});
          }else{
            this.comments.unshift({id: +d.id, answer: +answer,image: this.image, username: this.username, date: date, msg: msg,elements: []});
          }
        }
      });
  }

  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }
}
