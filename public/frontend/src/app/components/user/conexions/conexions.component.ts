import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { UserHelperService } from '../user-helper.service';

import { URL } from '../../../constants/url.constant';
@Component({
  selector: 'app-conexions',
  templateUrl: './conexions.component.html',
  styleUrls: ['./conexions.component.css']
})
export class ConexionsComponent implements OnInit {
  public subData:  Subscription;

  public conexions;
  public url = URL.user;
  constructor(
    private userHelper: UserHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }
  getData(){
    this.subData = this.userHelper.getConexions().subscribe( d => {
      this.conexions = d.c;
    });
  }
  
  updateData(c: any, s: string){
    if(s == 'Ejected'){this.conexions = this.conexions.filter(h => h !== c);}
    this.userHelper.updateConexion({id: +c.id, status: s});
  }

  removeConexion(c:any){
    this.conexions = this.conexions.filter(h => h !== c);
    this.userHelper.removeConexion(c.id);
  }


  ngOnDestroy(){
    if(this.subData){this.subData.unsubscribe();}
  }
}
