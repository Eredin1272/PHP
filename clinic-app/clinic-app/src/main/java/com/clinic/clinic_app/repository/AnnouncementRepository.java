package com.clinic.clinic_app.repository;

import com.clinic.clinic_app.model.Announcement;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface AnnouncementRepository extends JpaRepository<Announcement, Long> {
    List<Announcement> findTop3ByOrderByPublishedAtDesc();
}
