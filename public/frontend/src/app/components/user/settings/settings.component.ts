import { Component, OnInit } from '@angular/core';
import { UserHelperService } from '../user-helper.service';

@Component({
  selector: 'app-settings',
  templateUrl: './settings.component.html',
  styleUrls: ['./settings.component.css']
})
export class SettingsComponent implements OnInit {

  public settings;
  constructor(
    private userHelper:  UserHelperService
  ) { }

  ngOnInit() {
    this.getData();
  }

  getData(){
    this.userHelper.getSettings().subscribe( d => {
      this.settings = d.s;
    })
  }
}
