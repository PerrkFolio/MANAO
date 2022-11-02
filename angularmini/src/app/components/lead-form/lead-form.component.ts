import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Category } from 'src/app/models/category';
import { Lead } from 'src/app/models/lead';
import { Status } from 'src/app/models/status';
import { CategoryService } from 'src/app/services/category.service';
import { LeadService } from 'src/app/services/lead.service';
import { StatusService } from 'src/app/services/status.service';

@Component({
  selector: 'app-lead-form',
  templateUrl: './lead-form.component.html',
  styleUrls: ['./lead-form.component.sass']
})
export class LeadFormComponent implements OnInit {



  form: FormGroup;
  statuses : Status[];
  categories: Category[];

  id: number;

  lead : Lead;

  constructor(
    private statusService: StatusService,
    private categoryService: CategoryService,
    private leadService: LeadService,

    private router: Router,
    private activateRoute: ActivatedRoute,
  ) { 

    this.lead = {
      id: 0,
      link: '',
      is_express_delivery: false,
      comment : '',
      category_id: 0,
      status_id: 0,
    }

    this.id = this.activateRoute.snapshot.params['id'];

  }

  ngOnInit(): void {
    this.getStatuses();
    this.getCategories();

    this.getLead();

    this.form = new FormGroup({
      link: new FormControl(this.lead.link,[Validators.required]),
      category_id: new FormControl(this.lead.category_id,[Validators.required, Validators.min(1)]),
      status_id: new FormControl(this.lead.status_id,[Validators.required, Validators.min(1)]),

      comment: new FormControl(this.lead.comment,[Validators.required]),
      is_express_delivery: new FormControl(this.lead.is_express_delivery),
    });
  }
  getLead() {
    if(this.id) {
      this.leadService.getLead(this.id).subscribe((data)=> {
        if(data) {
          this.lead = data;
          this.form.patchValue(this.lead);
        }
      });
    }
  }

  get f() {return this.form.controls}

  getCategories() {
    this.categoryService.getCategories().subscribe((data)=> {
      this.categories = data;
    });
  }
  getStatuses() {
    this.statusService.getStatuses().subscribe((data)=> {
      this.statuses = data;
    });
  }

  onSubmit() {

    if(this.form.invalid) {
      return;
    }

    Object.assign(this.lead, this.form.value);

    if(this.id) {
      this.updateLead();
    }
    else {
      this.storeLead();
    }

  }
  storeLead() {
    this.leadService.storeLead(this.lead).subscribe((data)=>{
        if(data) {
            this.router.navigate(['']);
        }
    });
  }
  updateLead() {
    this.leadService.updateLead(this.lead).subscribe((data)=>{
      if(data) {
          this.router.navigate(['']);
      }
  });
  }

}
