import { Component, Input } from '@angular/core';
import { URL } from '../../../../constants/url.constant';
@Component({
  selector: 'app-p-service',
  templateUrl: './p-service.component.html',
  styleUrls: ['./p-service.component.css']
})
export class PServiceComponent{
  public url = URL.service;
  @Input() public services = [];
  @Input() public settings = [];

  constructor(
  ) { }
}
