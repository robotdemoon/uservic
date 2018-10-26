import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-p-perfil',
  templateUrl: './p-perfil.component.html',
  styleUrls: ['./p-perfil.component.css']
})
export class PPerfilComponent implements OnInit {
  @Input() public user = [];
  @Input() public contacts = [];

  constructor() { }

  ngOnInit() {
    
  }

}
